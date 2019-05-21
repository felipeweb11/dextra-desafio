import React  from 'react';
import { MdAddShoppingCart } from 'react-icons/md';
import SnackIngredientCard from './SnackIngredientCard';

function CustomSnackBuilder({customSnack, availableIngredients, promotions, onIngredientQuantityChange}) {
  return (
    <div className="row text-center mb-5">
      <div className="col-lg-12">
        <div className="card shadow-sm">
          <div className="card-header d-flex align-items-center justify-content-center" style={{"height": "100px"}}>
            <h4 className="my-1 font-weight-bold text-blue">{customSnack.name}</h4>
          </div>
          <div className="card-body d-flex flex-column">
            <div className="text-center mb-3">
              <img className="img-fluid" style={{"width": "350px"}} src={`/images/snacks/custom.png`} alt=""/>
            </div>
            <h1 className="card-title pricing-card-title text-success">
              {customSnack.price}
            </h1>
            <div className="card-columns mt-5">
              {availableIngredients.map(ingredient => {
                let quantity = 0;
                const snackIngredient = customSnack.ingredients.data.find((i) => i.id === ingredient.id);
                if (snackIngredient) {
                  quantity = snackIngredient.quantity;
                }
                return (<SnackIngredientCard key={ingredient.id} {...ingredient} quantity={quantity} onChangeQuantity={onIngredientQuantityChange} />);
              })}
            </div>
            <div className="row text-left mt-5 mb-5">
              <div className="col-lg-12">
               <div className="alert alert-info">
                 <h5 className="h5">Promoções: </h5>
                 <ul className="list">
                   {promotions.map(promo => <li key={promo.id}>{promo.name} - {promo.description}</li>)}
                 </ul>
               </div>
              </div>
            </div>
            <button type="button" className="mt-auto btn btn-lg btn-block btn-outline-success">
              <MdAddShoppingCart/> Adicionar
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default CustomSnackBuilder;

