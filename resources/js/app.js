/**
 * First, we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');  // Isso carrega o arquivo bootstrap.js padrão do Laravel

// Importação das bibliotecas necessárias
import React from 'react';
import ReactDOM from 'react-dom';

// Importação do componente React
import SearchForm from './components/SearchForm';  // Seu componente React

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Renderizar o componente SearchForm dentro do div com id "search-react"
if (document.getElementById('search-react')) {
    ReactDOM.render(<SearchForm />, document.getElementById('search-react'));
}
