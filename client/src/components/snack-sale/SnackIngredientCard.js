import React from 'react';

function SnackIngredientCard({id, name, price, image, quantity, onChangeQuantity}) {
  return (
    <div className="card">
      <div className="card-header"><h4><small>{name} - {price}</small></h4></div>
      <div className="card-body">
        <img className="img-fluid" style={{"maxWidth": "80px"}} src={`/images/ingredients/${image}`} alt=""/>
      </div>
      <div className="card-footer">
        <div className="input-group mb-3">
          <div className="input-group-prepend">
            <span className="input-group-text" id="inputGroup-sizing-default">Qtd: </span>
          </div>
          <input type="number" min={0} value={quantity} onChange={(event) => onChangeQuantity(id, quantity, event.target.value)} className="form-control" aria-label="Default" />
        </div>
      </div>
    </div>
  );
}

export default SnackIngredientCard;
