import React from "react";
import "./Login.css";
const Input = (props) => {
  return (
    <>
      <div className="input-block">
        <label htmlFor={props.for} className="input-label">
          {props.label}
        </label>
        <input type={props.type} name={props.name}  placeholder={props.placeholder} />
      </div>
    </>
  );
};

export default Input;
