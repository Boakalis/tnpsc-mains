import React, { useRef, useState, useEffect, useImperativeHandle } from "react";
import { createPortal } from "react-dom";
import { useSelector, useDispatch } from "react-redux";
import axios from "../helpers/axios";
import "./Login.css";
import { Row, Container, Col } from "react-bootstrap";
import "https://use.fontawesome.com/releases/v5.0.10/js/all.js";
import { toastr } from "react-redux-toastr";

const ChangePassword = React.forwardRef((props, ref) => {
  const passwordBlock = useRef();
  const confirmPasswordBlock = useRef();
  const passwordInputRef = useRef();
  const confirmPasswordInputRef = useRef();
  const modalState = useSelector(
    (state) => state.modalReducer.isChangePasswordOpen
  );
  const dispatch = useDispatch();
  useEffect(() => {
    passwordInputRef.current.focus();
  });

  const closeModal = () => {
    dispatch({ type: "CLOSE_CHANGE_PASSWORD_MODAL" });
  };

  const ChangePassword = () => {
    let password = passwordInputRef.current;
    let confirmPassword = confirmPasswordInputRef.current;
    if (password.value == "") {
      password.focus();
      passwordBlock.current.classList.add("error");
      return;
    } else {
      passwordBlock.current.classList.remove("error");
    }

    if (!(password.value.length >= 6)) {
      password.focus();
      passwordBlock.current.classList.add("error");
      toastr.error("Oops!!!", "Password must be atleast 6 characters");
      setTimeout(() => {
        toastr.removeByType("error");
      }, 5000);
      return;
    } else {
      passwordBlock.current.classList.remove("error");
    }

    if (confirmPassword.value == "") {
      confirmPasswordBlock.current.classList.add("error");
      confirmPassword.focus();
      return;
    } else {
      confirmPasswordBlock.current.classList.remove("error");
    }

    if (!(confirmPassword.value === password.value)) {
      confirmPassword.focus();
      confirmPasswordBlock.current.classList.add("error");
      toastr.error("Oops!!!", "Password and Confirm Password must be same");
      setTimeout(() => {
        toastr.removeByType("error");
      }, 5000);
      return;
    } else {
      confirmPasswordBlock.current.classList.remove("error");
    }

    axios.post('/change-password',{
      password:password.value,
      confirmPassword: confirmPassword.value,
    })
    .then((resp)=>{
      if(resp.data.status == 200){
        toastr.success('Password Changed Successfully')
        setTimeout(()=>{
          toastr.removeByType('error')
        },3000)
      }
      dispatch({type:'CLOSE_CHANGE_PASSWORD_MODAL'})
     })
    .catch((error)=>{
      if (error.response.status == 422) {
        toastr.error('Oops!! , Required Fields are missed or in bad formate');
      }
    })


  };

  return (
    <>
      {createPortal(
        <>
          <div className={`modal  ${modalState ? "is-open" : "d-none"}`}>
            <div className="modal-container">
              <div className="modal-left col-12 p-4">
                <h1 className="modal-title">Change Password</h1>
                <p className="modal-desc"></p>
                <div className="row">
                  <div className="input-block col-5 mx-2" ref={passwordBlock}>
                    <label htmlFor="password" className="input-label">
                      New Password
                    </label>
                    <input
                      type="password"
                      name="password"
                      ref={passwordInputRef}
                      id="email"
                      placeholder="Enter New Password"
                    />
                  </div>
                  <div className="input-block col-5 mx-2" ref={confirmPasswordBlock}>
                    <label htmlFor="confirmPassword" className="input-label">
                      Confirm Password
                    </label>
                    <input
                      type="password"
                      name="confirm_password"
                      ref={confirmPasswordInputRef}
                      id="email"
                      placeholder="Confirm New Password"
                    />
                  </div>
                </div>
                <div className="modal-buttons">
                  <a href="" className=""></a>
                  <button onClick={ChangePassword} className="input-button">
                    Change Password
                  </button>
                </div>
              </div>
              {/* <div className="modal-right">
                <img src="/assets/img/boy.jpg" alt="" />
              </div> */}
              <button onClick={closeModal} className="icon-button close-button">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                  <path d="M 25 3 C 12.86158 3 3 12.86158 3 25 C 3 37.13842 12.86158 47 25 47 C 37.13842 47 47 37.13842 47 25 C 47 12.86158 37.13842 3 25 3 z M 25 5 C 36.05754 5 45 13.94246 45 25 C 45 36.05754 36.05754 45 25 45 C 13.94246 45 5 36.05754 5 25 C 5 13.94246 13.94246 5 25 5 z M 16.990234 15.990234 A 1.0001 1.0001 0 0 0 16.292969 17.707031 L 23.585938 25 L 16.292969 32.292969 A 1.0001 1.0001 0 1 0 17.707031 33.707031 L 25 26.414062 L 32.292969 33.707031 A 1.0001 1.0001 0 1 0 33.707031 32.292969 L 26.414062 25 L 33.707031 17.707031 A 1.0001 1.0001 0 0 0 32.980469 15.990234 A 1.0001 1.0001 0 0 0 32.292969 16.292969 L 25 23.585938 L 17.707031 16.292969 A 1.0001 1.0001 0 0 0 16.990234 15.990234 z" />
                </svg>
              </button>
            </div>
          </div>
        </>,
        document.getElementById("modal-profile")
      )}
    </>
  );
});

export default ChangePassword;
