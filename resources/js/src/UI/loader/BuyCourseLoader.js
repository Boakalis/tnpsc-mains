import React from "react";
import "./TextLoader.css";
import {useNavigate} from 'react-router-dom'
const BuyCourse = () => {
  const navigate = useNavigate()
  return (
    <>
      <div className="container-loader">
        <h6 className="mb-o">
          <span>
           No Result Found
          </span>{" "}<br/>
          <button onClick={()=>{
            navigate('/exams')
          }} class="btn my-2 text-dark btn-success text-uppercase">Browse  Courses</button>
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

export default BuyCourse;
