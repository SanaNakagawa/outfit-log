import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import 'tailwindcss/tailwind.css'

import flatpickr from 'flatpickr';
import 'flatpickr/dist/themes/material_green.css';

flatpickr('.datepicker', {
    dateFormat: 'Y-m-d',
    defaultDate: 'today', // 今日の日付をデフォルトに
});