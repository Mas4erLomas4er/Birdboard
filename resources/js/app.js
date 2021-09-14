import Vue from 'vue';
import VModal from 'vue-js-modal';
import './bootstrap'

Vue.component( 'theme-switcher', require( './components/ThemeSwitcher' ).default );
Vue.component( 'new-project-modal', require( './components/NewProjectModal' ).default );
Vue.component( 'dropdown', require( './components/Dropdown' ).default );
Vue.use( VModal )

const app = new Vue( {
    el : '#app',
} );
