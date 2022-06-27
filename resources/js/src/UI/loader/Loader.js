import React from "react";
import "./loader.css";
import "./TextLoader.css";

const Loader = () => {
  return (
    <>

        {/* <div id="preloader-active">
        <div className="preloader d-flex align-items-center justify-content-center">
            <div className="preloader-inner position-relative">
                <div className="preloader-circle"></div>
                <div className="preloader-img pere-text">
                    <img src="/frontend/assets/img/logo/loder.png" alt="" /><br />
                    <p style={{fontSize: "10px"}} className="">Please Wait</p>
                </div>
            </div>
        </div>
    </div> */}

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

export default Loader;
