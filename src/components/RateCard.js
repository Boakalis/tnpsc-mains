import React from "react";
import style from "./RateCardStyle.module.css";
import Button from "@mui/material/Button";

const RateCard = (props) => {

  return (
    <>

       <  div className={`${style['banner-top-promo']} ${style.flash}`}>
        <strong></strong> &nbsp;{`Get access to our entire catalog
        of ${props.data.name} and in-depth classes for only `}<strong>&#8377;{props.price}</strong> <Button variant="contained" className ="mx-2"  small="small" color="success">
        Buy Now
      </Button>
      </div>
    </>
  );
};

export default RateCard;
