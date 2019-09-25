// Vue.js
import Vue from 'vue';
import AppComponent from './components/AppComponent';


let app = document.getElementById('app');

if(app){

    new Vue({
        el: '#app',
        components: {
            application: AppComponent
        }
    });
}