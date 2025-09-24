import '../css/app.css';
import './bootstrap';
import Alpine from 'alpinejs';
import dashboard from './dashboard';
window.Alpine = Alpine;
Alpine.data('measurementDashboard', dashboard);
Alpine.start();