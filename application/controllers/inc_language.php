<?php

if ($center_type == "day_care") {
    if ($site_lang == 'arabic') {
        $this->lang->load('arabic', 'arabicDayCare');
    } elseif ($site_lang == 'english') {
        $this->lang->load('english', 'english');
    } elseif ($site_lang == 'french') {
        $this->lang->load('french', 'french');
    } elseif ($site_lang == 'spanish') {
        $this->lang->load('spanish', 'spanish');
    } elseif ($site_lang == 'kurdish') {
        $this->lang->load('kurdish', 'kurdish');
    } else {
        $this->lang->load('arabic', 'arabicDayCare');
    }
} elseif ($center_type == "clinic") {
    if ($site_lang == 'arabic') {
        $this->lang->load('arabic', 'arabicClinic');
    } elseif ($site_lang == 'english') {
        $this->lang->load('english', 'english');
    } else {
        $this->lang->load('arabic', 'arabicClinic');
    }
} else {
    $this->lang->load('arabic', 'arabic');
}