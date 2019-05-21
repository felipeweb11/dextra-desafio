import React from 'react';
import { MdAddShoppingCart } from 'react-icons/md';

function SnackCard({name, image, price, ingredients}) {
  return (
    <div className="col-sm-6 col-md-4 col-lg-3 mb-4 h-auto">
      <div className="card shadow-sm h-100">
        <div className="card-header d-flex align-items-center justify-content-center" style={{'height': '100px'}}>
          <h4 className="my-1 font-weight-bold text-blue">{name}</h4>
        </div>
        <div className="card-body d-flex flex-column">
          <div className="text-center mb-3">
            <img className="img-fluid" src={`/images/snacks/${image}`} alt=""/>
          </div>
          <h1 className="card-title pricing-card-title">
            <small className="text-success">{price}</small>
          </h1>
          <ul className="list text-left mt-3 mb-4">
            {ingredients.data.map(ingredient => <li key={ingredient.id}>{ingredient.name}</li>)}
          </ul>
          <button type="button" className="mt-auto btn btn-lg btn-block btn-outline-success">
            <MdAddShoppingCart/> Adicionar
          </button>
        </div>
      </div>
    </div>
  );
}

export default SnackCard;
