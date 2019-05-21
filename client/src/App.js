import React from 'react';
import './App.scss';
import SnackMenuContainer from './components/snack-sale/SnackMenuContainer';
import CustomSnackBuilderContainer from './components/snack-sale/CustomSnackBuilderContainer';

function App() {
  return (
    <div className="App">
      <div className="container">
        <h1 className="h1 mt-5 mb-5 text-center"><img src="/images/logo.png" alt=""/> Lanches</h1>

        <h3 className="mb-4"><small>Escolha as opções do nosso cardápio:</small></h3>

        <SnackMenuContainer />

        <h3 className="mb-4"><small>Ou se preferir monte o seu próprio lanche:</small></h3>
        <CustomSnackBuilderContainer />
      </div>
    </div>
  );
}

export default App;
