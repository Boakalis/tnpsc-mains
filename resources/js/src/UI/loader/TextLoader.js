import React from "react";
import "./TextLoader.css";

const TextLoader = () => {
  return (
    <>
      <div className="container-loader">
        <h6 className="mb-o">
          <span>
            Please wait
          </span>{" "}
          {/* is loading */}
        </h6>
        <div className="loading">
          <div className="ball"></div>
          <div className="ball"></div>
          <div className="ball"></div>
          <div className="ball"></div>
          <div className="ball"></div>
        </div>
      </div>
    </>
  );
};

export default TextLoader;
