@extends('page::frontend.layout.master')
@section('meta_title'){{ $data->meta_title }}@endsection
@section('meta_desc'){{ $data->meta_desc }}@endsection
@section('meta_keyw'){{ $data->meta_keyw }}@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/drift-zoom/dist/drift-basic.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/simplebar/dist/simplebar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/choices.js/public/assets/styles/choices.min.css') }}">
@endsection
@section('content')
    @php
        $finalPrice = $data->sale_price ?? $data->price;
            $variants = \App\Models\Productvars::where('product_token',$data->product_token)->get();
            $variantGroups = $variants->groupBy(function ($variant) {
                return $variant->variant_type ?: 'Genel';
            });
            $galleryImages = collect([$data->image])
                ->merge(
                    \App\Models\Images::where('product_token', $data->product_token)
                        ->pluck('image')
                )
                ->filter()
                ->unique()
                ->values();
            $variantGalleryItems = $variants->filter(function ($variant) {
                return !empty($variant->variant_image);
            });
    @endphp

    @include('product::frontend.product.new.detail')

    @section('js')

        <script>
            (function () {
                const hiddenVariantInput = document.getElementById('variantSelect');
                if (!hiddenVariantInput) return;

                const variantGroupSelects = document.querySelectorAll('.variant-group-select');
                const warningNode = document.getElementById('variantStockWarning');
                const addToCartBtn = document.getElementById('addToCartBtn');

                const showWarning = (message) => {
                    if (!warningNode) return;
                    warningNode.textContent = message;
                    warningNode.classList.remove('d-none');
                };

                const hideWarning = () => {
                    if (!warningNode) return;
                    warningNode.classList.add('d-none');
                    warningNode.textContent = '';
                };

                // 🔥 RENK ID BUL
                const getSelectedColorVariantId = () => {
                    const selectedColor = document.querySelector('.color-options input[type="radio"]:checked');
                    return selectedColor ? selectedColor.value : null;
                };

                const selectedOptionByType = () => {
                    const selections = {};

                    // SELECT
                    variantGroupSelects.forEach((selectEl) => {
                        if (!selectEl.value) return;

                        const current = selectEl.options[selectEl.selectedIndex];
                        if (!current) return;

                        selections[selectEl.dataset.variantType] = {
                            id: current.value,
                            name: (current.dataset.variantName || '').trim(),
                            type: selectEl.dataset.variantType,
                            parentType: (current.dataset.parentVariantType || '').trim(),
                            parentName: (current.dataset.parentVariantName || '').trim(),
                        };
                    });

                    // RADIO (RENK)
                    document.querySelectorAll('.color-options input[type="radio"]:checked').forEach((radio) => {
                        const type = radio.name.replace('variant_', '');

                        selections[type] = {
                            id: radio.value,
                            name: (radio.dataset.variantName || '').trim(),
                            type: type,
                            parentType: (radio.dataset.parentVariantType || '').trim(),
                            parentName: (radio.dataset.parentVariantName || '').trim(),
                        };
                    });

                    return selections;
                };

                const parseVariantNames = (value) => {
                    return (value || '')
                        .split(',')
                        .map((item) => item.trim())
                        .filter(Boolean);
                };

                const variantNameMatches = (rawExpectedNames, actualName) => {
                    const expectedNames = parseVariantNames(rawExpectedNames);
                    if (expectedNames.length === 0) return true;
                    return expectedNames.includes((actualName || '').trim());
                };

                const isCompatibleWithSelections = (targetType, option, selections) => {
                    const optionName = (option.dataset.variantName || '').trim();
                    const optionParentType = (option.dataset.parentVariantType || '').trim();
                    const optionParentName = option.dataset.parentVariantName || '';

                    return Object.values(selections).every((selected) => {
                        if (selected.type === targetType) return true;

                        const optionRequiresSelected = !optionParentType
                            || optionParentType !== selected.type
                            || variantNameMatches(optionParentName, selected.name);

                        const selectedRequiresOption = !selected.parentType
                            || selected.parentType !== targetType
                            || variantNameMatches(selected.parentName, optionName);

                        return optionRequiresSelected && selectedRequiresOption;
                    });
                };

                const refreshOptionAvailability = () => {
                    const selections = selectedOptionByType();

                    variantGroupSelects.forEach((selectEl) => {
                        const selectType = selectEl.dataset.variantType;

                        Array.from(selectEl.options).forEach((option, index) => {
                            if (index === 0) return;

                            const originalStock = parseInt(option.dataset.stock || '0', 10);
                            const compatible = isCompatibleWithSelections(selectType, option, selections);
                            const available = compatible && originalStock > 0;

                            option.disabled = !available;
                            option.hidden = !compatible;
                        });

                        if (selectEl.value) {
                            const currentOption = selectEl.options[selectEl.selectedIndex];
                            if (!currentOption || currentOption.disabled) {
                                selectEl.value = '';
                            }
                        }
                    });
                };

                const resolveSelectedVariant = () => {
                    const selectedOptions = Array.from(variantGroupSelects)
                        .map((selectEl) => {
                            if (!selectEl.value) return null;

                            const selected = selectEl.options[selectEl.selectedIndex];
                            return selected ? {
                                id: selected.value,
                                stock: parseInt(selected.dataset.stock || '0', 10),
                                parentType: (selected.dataset.parentVariantType || '').trim(),
                            } : null;
                        })
                        .filter(Boolean);

                    if (selectedOptions.length !== variantGroupSelects.length) return null;

                    return selectedOptions.find((item) => item.parentType)
                        || selectedOptions[selectedOptions.length - 1]
                        || null;
                };

                const updateVariantState = (resolvedVariant) => {
                    if (!resolvedVariant) {
                        addToCartBtn && (addToCartBtn.disabled = true);
                        hiddenVariantInput.value = '';
                        showWarning('Lütfen tüm varyant seçeneklerini seçiniz.');
                        return;
                    }

                    const stock = parseInt(resolvedVariant.stock || '0', 10);

                    if (stock <= 0) {
                        addToCartBtn && (addToCartBtn.disabled = true);
                        hiddenVariantInput.value = '';
                        showWarning('Seçtiğiniz varyant stokta yok.');
                        return;
                    }

                    hiddenVariantInput.value = resolvedVariant.id;
                    addToCartBtn && (addToCartBtn.disabled = false);
                    hideWarning();
                };

                const syncSliderByVariant = (variantId) => {
                    if (!variantId) return;

                    const slides = document.querySelectorAll('.swiper .swiper-slide');

                    slides.forEach((slide, index) => {
                        if (slide.dataset.variantId == variantId) {

                            const swiperEl = document.querySelector('.swiper');
                            if (swiperEl && swiperEl.swiper) {
                                swiperEl.swiper.slideToLoop(index); // loop varsa bu önemli
                            }

                        }
                    });
                };

                // 🔥 SELECT CHANGE
                variantGroupSelects.forEach((groupSelect) => {
                    groupSelect.addEventListener('change', function () {

                        refreshOptionAvailability();

                        const resolvedVariant = resolveSelectedVariant();

                        // 🎯 RENK ÖNCELİK
                        const colorVariantId = getSelectedColorVariantId();

                        syncSliderByVariant(colorVariantId || (resolvedVariant ? resolvedVariant.id : null));

                        updateVariantState(resolvedVariant);
                    });
                });

                // 🔥 RADIO → SELECT SENKRON
                document.querySelectorAll('.color-options input[type="radio"]').forEach((radio) => {

                    radio.addEventListener('change', function () {

                        const variantId = this.value;
                        const variantType = this.name.replace('variant_', '');

                        const select = document.querySelector(`.variant-group-select[data-variant-type="${variantType}"]`);

                        if (select) {
                            select.value = variantId;
                            select.dispatchEvent(new Event('change'));
                        }
                    });

                });

                // THUMBNAIL CLICK
                document.querySelectorAll('[data-variant-id]').forEach((item) => {
                    item.addEventListener('click', function () {
                        const variantId = this.dataset.variantId;
                        const variantType = this.dataset.variantType || 'Genel';

                        variantGroupSelects.forEach((groupSelect) => {
                            if (groupSelect.dataset.variantType === variantType) {
                                groupSelect.value = variantId;
                            }
                        });

                        refreshOptionAvailability();
                        syncSliderByVariant(variantId);
                    });
                });

                if (variantGroupSelects.length > 0) {
                    refreshOptionAvailability();
                    addToCartBtn && (addToCartBtn.disabled = true);
                    showWarning('Lütfen tüm varyant seçeneklerini seçiniz.');
                }

            })();
        </script>

    @endsection
@endsection
