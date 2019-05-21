import React, { Component } from 'react';
import SnackMenu from './SnackMenu';
import { SnacksApi } from '../../services/SnacksApi';

export default class SnackMenuContainer extends Component {

  constructor(props) {
    super(props);
    this.state = {
      menu: null,
      loading: false
    };
  }

  async componentDidMount() {
    try {
      const menu = await SnacksApi.getDefaultSnackMenu();
      this.setState({menu});
    } catch (e) {
      console.log(e);
    }
  }

  render() {
    const {menu} = this.state;

    if (!menu) {
      return <div/>;
    }

    return (
      <SnackMenu menu={menu}/>
    );
  }
}
