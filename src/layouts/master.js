import { React, useRef } from "react";
import { Outlet } from "react-router-dom";
import Login from "../pages/Login";
import Footer from "./footer";
import NavBar from "./navbar";
import Sidebar from "./sidebar";
import AuthSecurity from './../helpers/AuthSecurity'
import Register from "../pages/Register";
import ForgetPassword from "../pages/ForgetPassword";
import MyProfile from "../pages/ChangePassword";
const Master = ({ children }) => {
  const emailInputRef = useRef();
  return (
    <>
      <AuthSecurity>
        <div className="layout-wrapper layout-content-navbar">
          <div className="layout-container">
            <Sidebar />

            <div className="layout-page">
              <NavBar />

              <div className="content-wrapper">
                <div className="container-xxl flex-grow-1 container-p-y">
                  <Outlet />
                </div>

                <Footer />

                <div className="content-backdrop fade"></div>
              </div>
            </div>
          </div>

          <div
            className="layout-overlay layout-menu-toggle"
            onClick={() => {
              document
                .getElementById("layout")
                .classList.remove("layout-menu-expanded");
            }}
          ></div>
        </div>
        <Login ref={emailInputRef}></Login>
        <Register ref={emailInputRef}></Register>
        <ForgetPassword ref={emailInputRef}></ForgetPassword>
        <MyProfile></MyProfile>
      </AuthSecurity>
    </>
  );
};

export default Master;
