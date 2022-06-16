import React from "react";
import "./loader.css";

const Loader = () => {
  return (
    <>
      {/* <div className="wrapper">
        <div className="loader" style={{
              left: '57%',
              right: '40%',
              top: '40%',
              bottom: '50%',
              position: 'absolute',
        }} >
          <h1 className="pip-0"></h1>
          <span className="pip-1"></span>
          <span className="pip-2"></span>
          <span className="pip-3"></span>
          <span className="pip-4"></span>
          <span className="pip-5"></span>
        </div>
        <h1 className="mt-3">Loading</h1>
      </div> */}
      <div id="spinner">
        <div className="bounce">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
    </>
  );
};

export default Loader;
