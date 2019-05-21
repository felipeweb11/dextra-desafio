import React from 'react';
import SnackCard from './SnackCard';

function SnackMenu({menu}) {
  return (
    <div className="row mb-3 text-center">
      {menu.snacks.data.map(snack => <SnackCard key={snack.id} {...snack}/>)}
    </div>
  );
}

export default SnackMenu;
