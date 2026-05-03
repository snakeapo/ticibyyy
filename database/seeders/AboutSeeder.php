<?php

namespace Database\Seeders;

use App\Models\Pages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pages::create([
            'id' => '1',
            'page_title' => 'Hakkımızda',
            'page_slug' => 'hakkimizda',
            'page_desc' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sagittis arcu risus, non scelerisque sem rhoncus nec. Maecenas vestibulum lacus id purus faucibus suscipit. Ut enim nibh, imperdiet sed dolor eu, dictum egestas turpis. Donec sit amet eros nunc. Donec dictum justo lacus. Ut id risus pretium, fringilla sapien at, aliquet tellus. Pellentesque aliquet risus ac sapien fringilla mattis. Quisque eros enim, auctor eget nibh quis, molestie venenatis magna. Donec molestie lorem sit amet massa hendrerit, a consectetur tellus suscipit.</p>

            <p>Aenean malesuada tellus vel molestie pretium. Suspendisse sit amet ullamcorper magna, sed vestibulum nunc. Nunc eu euismod nisl. Sed porttitor ornare quam, in facilisis erat accumsan nec. Pellentesque porta metus at lectus luctus porta. Etiam tempor sodales malesuada. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed maximus quam nec elementum auctor. Etiam vel auctor ipsum. Vestibulum eleifend consectetur arcu. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>

            <p>Nunc ac rhoncus eros, fermentum accumsan diam. Phasellus nec neque nec urna pretium sollicitudin. Mauris faucibus efficitur eros, eget blandit elit suscipit eget. Suspendisse eget consectetur lectus. Nam mattis velit et dolor vulputate, at bibendum purus egestas. Mauris tincidunt arcu ac lacus finibus imperdiet. Donec non sapien sit amet nibh pulvinar ullamcorper a eget massa. Maecenas lobortis sapien ac elit imperdiet, sit amet tempor massa pulvinar.</p>

            <p>Vestibulum eget ipsum ut nunc tristique dictum sit amet quis diam. Quisque hendrerit eget libero vel finibus. Duis non metus ultricies, dictum mi quis, ultricies diam. Phasellus congue orci a est pulvinar vehicula. Maecenas et sodales urna. Nullam eu odio vitae sapien ultrices sollicitudin. In ac interdum arcu, non rutrum sem. Integer congue rutrum eleifend. Aliquam erat volutpat. Cras in faucibus metus. Praesent eget urna ac lectus fringilla aliquam eget quis mauris. Proin tellus eros, volutpat eget viverra non, mollis in eros.</p>

            <p>In egestas rutrum dui ac bibendum. Integer egestas ex in maximus dignissim. Integer et elit vel felis bibendum pellentesque et nec dui. Nullam malesuada ante sit amet sodales elementum. Fusce eget lectus lorem. Praesent quis lectus eu velit mollis hendrerit. In hac habitasse platea dictumst. Cras convallis magna et tellus ultricies vulputate. Aliquam vitae massa at ipsum bibendum sollicitudin. Phasellus tincidunt mi at eros suscipit consectetur. Aliquam erat volutpat. Nullam erat libero, vestibulum eu porta vitae, elementum sed sapien. Aenean ac mauris sagittis, consectetur eros quis, dapibus quam. Nam feugiat justo vel arcu semper semper.</p>',
            'meta_title' => 'Hakkımızda',
            'meta_keyw' => 'Hakkımızda',
            'meta_desc' => 'Hakkımızda',

        ]);
    }
}
