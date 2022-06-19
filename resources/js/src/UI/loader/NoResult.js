import React from "react";
import "./TextLoader.css";

const Nr = () => {
  return (
    <>
      <div className="container-loader">
        <h6 className="mb-o">
          <span>
           No Result Found
          </span>{" "}
          {/* is loading */}
        </h6>
        {/* <div className="loading">
          <div className="ball"></div>
          <div className="ball"></div>
          <div className="ball"></div>
          <div className="ball"></div>
          <div className="ball"></div>
        </div> */}
      </div>
    </>
  );
};

export default Nr;
