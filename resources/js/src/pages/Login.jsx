import React, { useRef, useState, useEffect, useImperativeHandle } from "react";
import { createPortal } from "react-dom";
import { useSelector, useDispatch } from "react-redux";
import axios from "../helpers/axios";
import "./Login.css";
import { Row, Container, Col } from "react-bootstrap";
// import "https://use.fontawesome.com/releases/v5.0.10/js/all.js";
import { toastr } from "react-redux-toastr";

const Login = React.forwardRef((props, ref) => {
  const emailInputRef = useRef();
  const emailBlock = useRef();
  const passwordBlock = useRef();
  const passwordInputRef = useRef();
  const modalState = useSelector((state) => state.modalReducer.isOpen);
  const dispatch = useDispatch();
  const authenticationState = useSelector((state) => state.authentication.user);
  const [initialState, setInitialState] = useState(false);
  useEffect(() => {
    emailInputRef.current.focus();
  });

  // useEffect(()=>{
  //   if(initialState)
  // },[])

  const closeModal = () => {
    dispatch({ type: "CLOSE_LOGIN_MODAL" });
  };

  const openRegisterModal = () => {
    dispatch({ type: "CLOSE_LOGIN_MODAL" });
    dispatch({ type: "OPEN_REGISTER_MODAL" });
  };

  const Login = () => {
    let email = emailInputRef.current;
    let password = passwordInputRef.current;
    if (email.value != "" && email.value.includes("@") && email.value.includes('.') && email.value.includes('com') ) {
      emailBlock.current.classList.remove("error");

      if (password.value != "" && password.value.length >= 6) {
        passwordBlock.current.classList.remove("error"); 
        axios
          .post("/login", {
            email: email.value,
            password: password.value,
          })
          .then((resp) => {
            dispatch({ type: "LOGIN_START", payload: resp.data.user });
            localStorage.setItem("rawData", JSON.stringify(resp.data.token));
            toastr.success("Success", "Login Successful");
            dispatch({ type: "CLOSE_LOGIN_MODAL" });
            window.location.reload();
          })
          .catch((error) => {
            if (error.response.data.message == "NO_USER") {
              toastr.error(
                "User Not Found",
                "Please login with valid email or Register as new user"
              );
            } else if (error.response.data.message == "INVALID_CREDENTIALS") {
              toastr.error(
                "Invalid Credentials",
                "Please check credentials !!!"
              );
            }else{
              toastr.error('Something went wrong','Please try again later or contact support')
            }
            setTimeout(()=>{
              toastr.removeByType('error')
            },5000)
          });
      } else {
        password.focus();
        passwordBlock.current.classList.add("error");
      }
    } else {
      email.focus();
      emailBlock.current.classList.add("error");
    }
  };

  return (
    <>
      {createPortal(
        <>
          <div className={`modal  ${modalState ? "is-open" : "d-none"}`}>
            <div className="modal-container">
              <div className="modal-left">
                <h1 className="modal-title">Sign In</h1>
                <p className="modal-desc"></p>
                <div className="input-block" ref={emailBlock}>
                  <label htmlFor="email" className="input-label">
                    Email
                  </label>
                  <input
                    type="email"
                    name="email"
                    ref={emailInputRef}
                    id="email"
                    placeholder="Email"
                  />
                </div>
                <div className="input-block" ref={passwordBlock}>
                  <label htmlFor="password" className="input-label">
                    Password
                  </label>
                  <input
                    type="password"
                    name="password"
                    id="password"
                    ref={passwordInputRef}
                    placeholder="Password"
                  />
                </div>
                <div className="modal-buttons">
                  <a
                    href="javascript:void(0)"
                    onClick={() => {
                      dispatch({ type: "CLOSE_LOGIN_MODAL" });
                      dispatch({ type: "OPEN_FORGET_PASSWORD_MODAL" });
                    }}
                    className=""
                  >
                    Forgot your password?
                  </a>
                  <button onClick={Login} className="input-button">
                    Login
                  </button>
                </div>
                <p className="sign-up mt-3">
                  Don't have an account?{" "}
                  <a href="javascript:void(0)" onClick={openRegisterModal}>
                    Sign up now
                  </a>
                </p>
              </div>
              <div className="modal-right">
                <img src="/assets/img/boy.jpg" alt="" />
              </div>
              <button onClick={closeModal} className="icon-button close-button">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                  <path d="M 25 3 C 12.86158 3 3 12.86158 3 25 C 3 37.13842 12.86158 47 25 47 C 37.13842 47 47 37.13842 47 25 C 47 12.86158 37.13842 3 25 3 z M 25 5 C 36.05754 5 45 13.94246 45 25 C 45 36.05754 36.05754 45 25 45 C 13.94246 45 5 36.05754 5 25 C 5 13.94246 13.94246 5 25 5 z M 16.990234 15.990234 A 1.0001 1.0001 0 0 0 16.292969 17.707031 L 23.585938 25 L 16.292969 32.292969 A 1.0001 1.0001 0 1 0 17.707031 33.707031 L 25 26.414062 L 32.292969 33.707031 A 1.0001 1.0001 0 1 0 33.707031 32.292969 L 26.414062 25 L 33.707031 17.707031 A 1.0001 1.0001 0 0 0 32.980469 15.990234 A 1.0001 1.0001 0 0 0 32.292969 16.292969 L 25 23.585938 L 17.707031 16.292969 A 1.0001 1.0001 0 0 0 16.990234 15.990234 z" />
                </svg>
              </button>
            </div>
          </div>
        </>,
        document.getElementById("modal-root")
      )}
    </>
  );
});

export default Login;
