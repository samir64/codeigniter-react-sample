import React from 'react';
import ReactDOM from 'react-dom';
import 'bootstrap/dist/css/bootstrap.min.css';

import Main from './components/Main';
import Login from './components/Login';
import Dashboard from './components/Dashboard';
import NewProject from './components/NewProject';
import EditProject from './components/EditProject';
import HeaderNavbar from './components/HeaderNavbar';

import './styles/main.css';

const elements = document.getElementsByClassName('App');

const components = {
  Main,
  Login,
  Dashboard,
  NewProject,
  EditProject,
  HeaderNavbar
};

(() => {
  for (let i = 0; i <= elements.length; i++) {
    if (!elements[i]) return null;

    const currentComponent = Object.keys(components).find((component) => {
      let result = component === elements[i].id;

      if (result) {
        let props = {};
        Array.from(elements[i].attributes).forEach((atr) => {
          props[atr.name] = atr.value;
        });
        components[component] = React.createElement(
          components[component],
          props
        );
      }

      return result;
    });

    ReactDOM.render(
      components[currentComponent],
      document.getElementById(currentComponent)
    );
  }
})();
