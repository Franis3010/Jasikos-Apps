<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function editContent()
    {
        // provide English defaults when not set
        $data = [
            'home_about_blurb'   => Setting::getValue('home_about_blurb', 'We help cosplayers & brands turn ideas into production-ready visuals—clean, precise, and ready to use.'),
            'about_hero_title'   => Setting::getValue('about_hero_title', 'About Jasikos'),
            'about_hero_sub'     => Setting::getValue('about_hero_sub', 'We help you turn ideas into production-ready cosplay designs—clean, precise, and elegant.'),
            'about_body_html'    => Setting::getValue('about_body_html', '<p>Write the About content here (HTML allowed).</p>'),
            // optional: three services
            'about_service_1_t'  => Setting::getValue('about_service_1_t', 'Ready-to-Use Designs'),
            'about_service_1_d'  => Setting::getValue('about_service_1_d', 'A catalog of designs you can purchase instantly—practical and fast.'),
            'about_service_2_t'  => Setting::getValue('about_service_2_t', 'Custom Request'),
            'about_service_2_d'  => Setting::getValue('about_service_2_d', 'Designs created from your brief.'),
            'about_service_3_t'  => Setting::getValue('about_service_3_t', 'Production Support'),
            'about_service_3_d'  => Setting::getValue('about_service_3_d', 'Final files with detailed specifications.'),
            // optional: simple stats
            'about_stat_1_n'     => Setting::getValue('about_stat_1_n', '150+'),
            'about_stat_1_l'     => Setting::getValue('about_stat_1_l', 'Projects completed'),
            'about_stat_2_n'     => Setting::getValue('about_stat_2_n', '4.9/5'),
            'about_stat_2_l'     => Setting::getValue('about_stat_2_l', 'Average designer rating'),
            // CTA
            'about_whatsapp'     => Setting::getValue('about_whatsapp', '62895626141738'),
        ];
        return view('admin.settings.content', $data);
    }

    public function updateContent(Request $req)
    {
        $fields = [
            'home_about_blurb','about_hero_title','about_hero_sub','about_body_html',
            'about_service_1_t','about_service_1_d',
            'about_service_2_t','about_service_2_d',
            'about_service_3_t','about_service_3_d',
            'about_stat_1_n','about_stat_1_l',
            'about_stat_2_n','about_stat_2_l',
            'about_whatsapp',
        ];

        foreach ($fields as $k) {
            Setting::put($k, $req->input($k));
        }

        return back()->with('success','Site content saved successfully.');
    }
}
