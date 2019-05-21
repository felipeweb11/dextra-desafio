import React, { Component } from 'react';
import CustomSnackBuilder from './CustomSnackBuilder';
import { SnacksApi } from '../../services/SnacksApi';

export default class CustomSnackBuilderContainer extends Component {

  constructor(props) {
    super(props);
    this.state = {
      // Hardcoded customer id because user authentication will not be implemented
      customerId: '984376ee-382d-48d3-874b-64ca4e99b2ec',
      customSnack: null,
      availableIngredients: [],
      promotions: []
    };
  }

  async componentDidMount() {
    SnacksApi
      .getAvailableIngredients()
      .then((availableIngredients) => this.setState({availableIngredients}));

    SnacksApi
      .getPromotions()
      .then((promotions) => this.setState({promotions}));
  }

  createCustomSnack = () => {
    SnacksApi
      .createCustomSnack(this.state.customerId)
      .then((customSnack) => {
        this.setState({customSnack});
      });
  }

  refresh() {
    return SnacksApi
      .getCustomSnack(this.state.customSnack.id)
      .then(customSnack => this.setState({customSnack}));
  }

  onCustomSnackIngredientQuantityChange = (ingredientId, currentQuantity, newQuantity) => {
    if (newQuantity > currentQuantity) {
      const quantityToAdd = newQuantity - currentQuantity;
      SnacksApi
        .addCustomSnackIngredient(this.state.customSnack.id, ingredientId, quantityToAdd)
        .then(() => this.refresh());
    } else if (newQuantity < currentQuantity) {
      const quantityToRemove = currentQuantity - newQuantity;
      SnacksApi
        .removeCustomSnackIngredient(this.state.customSnack.id, ingredientId, quantityToRemove)
        .then(() => this.refresh());
    }
  }

  render() {
    const { customSnack, availableIngredients, promotions } = this.state;

    return (
      <div>
        {!customSnack && <button className="btn btn-success mb-5" onClick={this.createCustomSnack}>Montar lanche customizado</button>}
        {
          customSnack &&
          <CustomSnackBuilder
            customSnack={customSnack}
            availableIngredients={availableIngredients.data}
            promotions={promotions.data}
            onIngredientQuantityChange={this.onCustomSnackIngredientQuantityChange}
          />
        }
      </div>
    );
  }
}
