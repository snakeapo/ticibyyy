<?php

namespace Modules\Setting\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banks;
use App\Models\Cargos;
use App\Models\Infos;
use App\Models\Languages;
use App\Models\Settings;
use App\Models\AuthInfoCard;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Setting\Http\Requests\Backend\GeneralUpdateRequest;
use Modules\Setting\Http\Requests\Backend\SocialUpdateRequest;
use Modules\Setting\Http\Requests\Backend\ImageUpdateRequest;
use Modules\Setting\Http\Requests\Backend\ContactUpdateRequest;
use Modules\Setting\Http\Requests\Backend\ModuleUpdateRequest;
use Modules\Setting\Http\Requests\Backend\BankSettingCreateRequest;
use Modules\Setting\Http\Requests\Backend\BankSettingUpdateRequest;
use Modules\Setting\Http\Requests\Backend\CargoSettingCreateRequest;
use Modules\Setting\Http\Requests\Backend\CargoSettingUpdateRequest;
use Modules\Setting\Http\Requests\Backend\PosSettingUpdateRequest;
use Modules\Setting\Http\Requests\Backend\LanguageSettingCreateRequest;
use Modules\Setting\Http\Requests\Backend\LanguageSettingUpdateRequest;
use Modules\Setting\Http\Requests\Backend\InfoSettingCreateRequest;
use Modules\Setting\Http\Requests\Backend\InfoSettingUpdateRequest;
use Modules\Setting\Http\Requests\Backend\AuthInfoCardCreateRequest;
use Modules\Setting\Http\Requests\Backend\AuthInfoCardUpdateRequest;

class SystemController extends Controller
{

    //Web setting
/* ================================================================= */

    //Web setting
    public function web_setting()
    {
        $data = Settings::find(1);
        return view('setting::backend.items.setting.web-setting',compact('data'));
    }

    //Theme setting
    public function theme_setting()
    {
        return view('setting::backend.items.setting.theme-setting');
    }

    //Web post
    public function general_update(GeneralUpdateRequest $request,$id)
    {
        $formData = $request->validated();

        $setting = Settings::findOrFail($id);
        $setting->update($formData);
        return back()->with('success','Güncelleme İşlemi Başarılı!');
    }

    //Social post
    public function social_update(SocialUpdateRequest $request,$id)
    {
        $formData = $request->validated();

        $setting = Settings::findOrFail($id);
        $setting->update($formData);
        return back()->with('success','Güncelleme İşlemi Başarılı!');
    }


    //Image post
    public function image_update(ImageUpdateRequest $request,$id)
    {
        $validatedData = $request->validated();


        $setting = Settings::findOrFail($id);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = uniqid().'.'.$logo->getClientOriginalExtension();
            $logo->move(public_path('/upload/setting'), $logoName);
            $oldFilePath = public_path('/upload/setting/' . $setting->logo);
            if (!file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            $setting->logo = $logoName;
        }

        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $faviconName = uniqid().'.'.$favicon->getClientOriginalExtension();
            $favicon->move(public_path('/upload/setting'), $faviconName);
            $oldFilePath = public_path('/upload/setting/' . $setting->favicon);
            if (!file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            $setting->favicon = $faviconName;
        }

        if ($request->hasFile('light_logo')) {
            $icon = $request->file('light_logo');
            $iconName = uniqid().'.'.$icon->getClientOriginalExtension();
            $icon->move(public_path('/upload/setting'), $iconName);
            $oldFilePath = public_path('/upload/setting/' . $setting->light_logo);
            if (!file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            $setting->light_logo = $iconName;
        }

        $setting->save();

        return back()->with('success', 'Resimler Güncellendi!');
    }


    //Contact post
    public function contact_update(ContactUpdateRequest $request,$id)
    {
        $formData = $request->validated();

        $setting = Settings::findOrFail($id);
        $setting->update($formData);
        return back()->with('success','Güncelleme İşlemi Başarılı!');
    }


    //Module post
    public function module_update(ModuleUpdateRequest $request,$id)
    {
        $formData = $request->validated();

        $setting = Settings::findOrFail($id);
        $setting->update($formData);
        return back()->with('success','Güncelleme İşlemi Başarılı!');
    }


/* ================================================================= */


    //Bank setting
/* ================================================================= */

    //Bank setting
    public function bank_setting()
    {
        $data = Banks::all();
        return view('setting::backend.items.setting.bank-setting',compact('data'));
    }

    //Bank create
    public function bank_setting_create(BankSettingCreateRequest $request)
    {
        $formData = $request->validated();

        $insert = Banks::create($formData);
        return back()->with('success','Kayıt İşlemi Başarılı!');
    }

    //Bank update
    public function bank_setting_update(BankSettingUpdateRequest $request,$id)
    {
        $formData = $request->validated();

        $cargo = Banks::findOrFail($id);
        $cargo->update($formData);
        return back()->with('success','Güncelleme İşlemi Başarılı!');
    }

    //Bank delete
    public function bank_setting_delete($id)
    {
        $info = Banks::findOrFail($id);
        $info->delete();
        return back()->with('success','Silme İşlemi Başarılı!');
    }


/* ================================================================= */


    //Cargo setting
/* ================================================================= */

    //Cargo setting
    public function cargo_setting()
    {
        $data = Cargos::all();
        return view('setting::backend.items.setting.cargo-setting',compact('data'));
    }

    //Cargo create
    public function cargo_setting_create(CargoSettingCreateRequest $request)
    {
        $formData = $request->validated();

        if ($request->hasFile('cargo_image')) {
            $file = $request->file('cargo_image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/cargo'), $fileName);
        }else{
            $fileName = 0;
        }
        $formData['cargo_image'] = $fileName;
        $insert = Cargos::create($formData);
        return back()->with('success','Kayıt İşlemi Başarılı!');
    }

    //Cargo update
    public function cargo_setting_update(CargoSettingUpdateRequest $request,$id)
    {
        $formData = $request->validated();

        $cargo = Cargos::findOrFail($id);

        if ($request->hasFile('cargo_image')) {
            $file = $request->file('cargo_image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/cargo'), $fileName);

            $oldFilePath = public_path('/upload/cargo/' . $cargo->cargo_image);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            $formData['cargo_image'] = $fileName;
        }

        $cargo->update($formData);
        return back()->with('success','Güncelleme İşlemi Başarılı!');
    }

    //Cargo delete
    public function cargo_setting_delete($id)
    {
        $info = Cargos::findOrFail($id);
        $oldFilePath = public_path('/upload/cargo/' . $info->cargo_image);
        if ($info->cargo_image && file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
        $info->delete();
        return back()->with('success','Silme İşlemi Başarılı!');
    }

/* ================================================================= */


    //Pos setting
/* ================================================================= */

    //Pos setting
    public function pos_setting()
    {
        $data = Settings::find(1);
        return view('setting::backend.items.setting.pos-setting',compact('data'));
    }

    //Pos update
    public function pos_setting_update(PosSettingUpdateRequest $request,$id)
    {
        $formData = $request->validated();
        $pos = Settings::findOrFail($id);
        $pos->update($formData);
        return back()->with('success','Güncelleme İşlemi Başarılı!');
    }



/* ================================================================= */


    //Language setting
/* ================================================================= */

    //Language setting
    public function language_setting()
    {
        $defaults = [
            ['language_name' => 'Türkçe', 'language_code' => 'tr'],
            ['language_name' => 'English', 'language_code' => 'en'],
        ];

        foreach ($defaults as $default) {
            Languages::query()->firstOrCreate(
                ['language_code' => $default['language_code']],
                ['language_name' => $default['language_name'], 'image' => 0]
            );
            $this->ensureLanguageJsonExists($default['language_code']);
        }

        $data = Languages::query()->orderBy('id', 'desc')->get();
        return view('setting::backend.items.setting.language',compact('data'));
    }

    //Language create
    public function language_setting_create(LanguageSettingCreateRequest $request)
    {
        $formData = $request->validated();
        $formData['language_code'] = Str::lower($formData['language_code']);

        if (Languages::query()->where('language_code', $formData['language_code'])->exists()) {
            return back()->with('error', 'Bu dil kodu zaten mevcut.');
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/language'), $fileName);
        }else{
            $fileName = 0;
        }
        $formData['image'] = $fileName;
        Languages::create($formData);
        $this->ensureLanguageJsonExists($formData['language_code']);

        return back()->with('success','Kayıt İşlemi Başarılı!');
    }

    //Language update
    public function language_setting_update(LanguageSettingUpdateRequest $request,$id)
    {
        $formData = $request->validated();
        $formData['language_code'] = Str::lower($formData['language_code']);

        $language = Languages::findOrFail($id);
        $oldCode = $language->language_code;

        if (Languages::query()->where('language_code', $formData['language_code'])->where('id', '!=', $id)->exists()) {
            return back()->with('error', 'Bu dil kodu zaten mevcut.');
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/language'), $fileName);

            $oldFilePath = public_path('/upload/language/' . $language->image);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            $formData['image'] = $fileName;
        }

        $language->update($formData);

        if ($oldCode !== $formData['language_code']) {
            $oldPath = $this->getLangJsonPath($oldCode);
            $newPath = $this->getLangJsonPath($formData['language_code']);

            if (File::exists($oldPath) && !File::exists($newPath)) {
                File::copy($oldPath, $newPath);
            } else {
                $this->ensureLanguageJsonExists($formData['language_code']);
            }
        }

        return back()->with('success','Güncelleme İşlemi Başarılı!');
    }

    //Language delete
    public function language_setting_delete($id)
    {
        $info = Languages::findOrFail($id);

        if (in_array($info->language_code, ['tr', 'en'], true)) {
            return back()->with('error', 'Varsayılan diller silinemez.');
        }

        $oldFilePath = public_path('/upload/language/' . $info->image);
        if ($info->image && file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        $langFilePath = $this->getLangJsonPath($info->language_code);
        if (File::exists($langFilePath)) {
            File::delete($langFilePath);
        }

        $info->delete();

        return back()->with('success','Silme İşlemi Başarılı!');
    }

    public function language_setting_translate($id, Request $request)
    {
        $language = Languages::findOrFail($id);
        $translations = collect($this->readLanguageFile($language->language_code));

        if ($request->filled('search')) {
            $search = Str::lower($request->string('search')->toString());
            $translations = $translations->filter(function ($value, $key) use ($search) {
                return Str::contains(Str::lower((string) $key), $search) || Str::contains(Str::lower((string) $value), $search);
            });
        }

        $translations = $translations->sortKeys();
        $perPage = 25;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $items = $translations->forPage($currentPage, $perPage);

        $paginated = new LengthAwarePaginator(
            $items,
            $translations->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('setting::backend.items.setting.language-translate', [
            'language' => $language,
            'translations' => $paginated,
            'search' => $request->string('search')->toString(),
        ]);
    }

    public function language_setting_translation_update($id, Request $request)
    {
        $language = Languages::findOrFail($id);

        $validated = $request->validate([
            'key' => ['required', 'string'],
            'value' => ['nullable', 'string'],
        ]);

        $content = $this->readLanguageFile($language->language_code);
        $content[$validated['key']] = $validated['value'] ?? '';
        ksort($content);
        $this->writeLanguageFile($language->language_code, $content);

        return back()->with('success', 'Çeviri güncellendi.');
    }

    public function language_setting_translation_create($id, Request $request)
    {
        $language = Languages::findOrFail($id);

        $validated = $request->validate([
            'new_key' => ['required', 'string'],
            'new_value' => ['nullable', 'string'],
        ]);

        $content = $this->readLanguageFile($language->language_code);
        $key = trim($validated['new_key']);

        if (isset($content[$key])) {
            return back()->with('error', 'Bu çeviri anahtarı zaten var.');
        }

        $content[$key] = $validated['new_value'] ?? '';
        ksort($content);
        $this->writeLanguageFile($language->language_code, $content);

        return back()->with('success', 'Yeni çeviri satırı eklendi.');
    }

    private function getLangJsonPath(string $languageCode): string
    {
        return lang_path(Str::lower($languageCode).'.json');
    }

    private function ensureLanguageJsonExists(string $languageCode): void
    {
        $path = $this->getLangJsonPath($languageCode);

        if (File::exists($path)) {
            return;
        }

        $sourcePath = $this->getLangJsonPath('tr');
        if (!File::exists($sourcePath)) {
            $sourcePath = $this->getLangJsonPath('en');
        }

        if (File::exists($sourcePath)) {
            File::copy($sourcePath, $path);
            return;
        }

        $this->writeLanguageFile($languageCode, []);
    }

    private function readLanguageFile(string $languageCode): array
    {
        $this->ensureLanguageJsonExists($languageCode);
        $path = $this->getLangJsonPath($languageCode);

        $decoded = json_decode((string) File::get($path), true);

        return is_array($decoded) ? $decoded : [];
    }

    private function writeLanguageFile(string $languageCode, array $content): void
    {
        $path = $this->getLangJsonPath($languageCode);
        File::ensureDirectoryExists(dirname($path));
        File::put($path, json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }


/* ================================================================= */


    //Info setting
/* ================================================================= */

    //Info setting
    public function info_setting()
    {
        $data = Infos::all();
        return view('setting::backend.items.setting.info',compact('data'));
    }

    //Info create
    public function info_setting_create(InfoSettingCreateRequest $request)
    {
        $formData = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/info'), $fileName);
        }else{
            $fileName = 0;
        }
        $formData['image'] = $fileName;
        $insert = Infos::create($formData);
        return back()->with('success','Kayıt İşlemi Başarılı!');
    }

    //Info update
    public function info_setting_update(InfoSettingUpdateRequest $request,$id)
    {
        $formData = $request->validated();

        $info = Infos::findOrFail($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/info'), $fileName);

            $oldFilePath = public_path('/upload/info/' . $info->image);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $formData['image'] = $fileName;
        }

        $info->update($formData);
        return back()->with('success','Güncelleme İşlemi Başarılı!');
    }

    //Info delete
    public function info_setting_delete($id)
    {
        $info = Infos::findOrFail($id);
        $oldFilePath = public_path('/upload/info/' . $info->image);
        if ($info->image && file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
        $info->delete();
        return back()->with('success','Silme İşlemi Başarılı!');
    }

/* ================================================================= */



    //Auth info card setting
/* ================================================================= */

    public function auth_info_card_setting()
    {
        $data = AuthInfoCard::query()->orderByDesc('id')->get();
        return view('setting::backend.items.setting.auth-info-card', compact('data'));
    }

    public function auth_info_card_setting_create(AuthInfoCardCreateRequest $request)
    {
        if (AuthInfoCard::count() >= 8) {
            return back()->with('error', 'En fazla 8 adet kart ekleyebilirsiniz.');
        }

        $formData = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/auth-info-card'), $fileName);
        } else {
            $fileName = 0;
        }

        $formData['image'] = $fileName;
        AuthInfoCard::create($formData);

        return back()->with('success','Kayıt İşlemi Başarılı!');
    }

    public function auth_info_card_setting_update(AuthInfoCardUpdateRequest $request, $id)
    {
        if (AuthInfoCard::count() >= 8) {
            return back()->with('error', 'En fazla 8 adet kart ekleyebilirsiniz.');
        }

        $formData = $request->validated();

        $card = AuthInfoCard::findOrFail($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/auth-info-card'), $fileName);

            $oldFilePath = public_path('/upload/auth-info-card/' . $card->image);
            if ($card->image && file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $formData['image'] = $fileName;
        }

        $card->update($formData);

        return back()->with('success','Güncelleme İşlemi Başarılı!');
    }

    public function auth_info_card_setting_delete($id)
    {
        $card = AuthInfoCard::findOrFail($id);
        $oldFilePath = public_path('/upload/auth-info-card/' . $card->image);

        if ($card->image && file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        $card->delete();

        return back()->with('success','Silme İşlemi Başarılı!');
    }

/* ================================================================= */

}
