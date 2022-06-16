import React, { useRef, useState, useEffect, useImperativeHandle } from "react";
import { createPortal } from "react-dom";
import { useSelector, useDispatch } from "react-redux";
import axios from "../helpers/axios";
import "./Login.css";
import { Row, Container, Col } from "react-bootstrap";
import "https://use.fontawesome.com/releases/v5.0.10/js/all.js";
import { toastr } from "react-redux-toastr";

const Register = React.forwardRef((props, ref) => {
  const nameInputRef = useRef();
  const emailInputRef = useRef();
  const emailBlock = useRef();
  const nameBlock = useRef();
  const passwordBlock = useRef();
  const confirmPasswordBlock = useRef();
  const passwordInputRef = useRef();
  const confirmPasswordInputRef = useRef();
  const registerModalState = useSelector((state) => state.modalReducer.isRegisterOpen);
  const dispatch = useDispatch();
  const authenticationState = useSelector((state)=>state.authentication.user);
  const [initialState ,setInitialState] = useState(false);
  useEffect(() => {
    nameInputRef.current.focus();
  });

  useEffect(()=>{
    console.log(registerModalState)
  })

  const closeModal = () => {
    dispatch({type:'CLOSE_REGISTER_MODAL'});
  }
  const openLoginModal = () => {
    dispatch({type:'CLOSE_REGISTER_MODAL'});
    dispatch({type:'OPEN_LOGIN_MODAL'});
  }

  const Register = () => {
    let name = nameInputRef.current;
    let email = emailInputRef.current;
    let password = passwordInputRef.current;
    let confirmPassword = confirmPasswordInputRef.current;

    if (name.value == "" ) {
        name.focus();
        nameBlock.current.classList.add("error");
        return;
    }else{
        nameBlock.current.classList.remove("error");

    }

    if (!(name.value.length >= 6) ) {
        name.focus();
        nameBlock.current.classList.add("error");
        toastr.error('Oops!!!','Name must be atleast 6 characters')
        setTimeout(()=>{
            toastr.removeByType('error')
        },5000)
        return;
    }else{
        nameBlock.current.classList.remove("error");

    }



    if (email.value == "" || !(email.value.includes("@"))) {
        email.focus();
        emailBlock.current.classList.add("error");
        return;
    }else{
        emailBlock.current.classList.remove("error");

    }




    if (password.value == "" ) {
        password.focus();
        passwordBlock.current.classList.add("error");
        return;
    }else{
        passwordBlock.current.classList.remove("error");

    }

    if (!(password.value.length >= 6) ) {
        password.focus();
        passwordBlock.current.classList.add("error");
        toastr.error('Oops!!!','Password must be atleast 6 characters')
        setTimeout(()=>{
            toastr.removeByType('error')
        },5000)
        return;
    }else{
        passwordBlock.current.classList.remove("error");

    }

    if (confirmPassword.value == "") {
        confirmPasswordBlock.current.classList.add("error");
        confirmPassword.focus();
        return;
    }else{
        confirmPasswordBlock.current.classList.remove("error");

    }

    if (!(confirmPassword.value === password.value)) {
        confirmPassword.focus();
        confirmPasswordBlock.current.classList.add("error");
        toastr.error('Oops!!!','Password and Confirm Password must be same')
        setTimeout(()=>{
            toastr.removeByType('error')
        },5000)
        return;
    }else{
        confirmPasswordBlock.current.classList.remove("error");
    }

    axios
    .post("/register", {
      name: name.value,
      email: email.value,
      password: password.value,
      confirmPassword: confirmPassword.value,
    })
    .then((resp) => {
      localStorage.setItem('rawData',JSON.stringify(resp.data.token))
      toastr.success("Success", "Register Successful");
      dispatch({type:'CLOSE_REGISTER_MODAL'});    
      window.location.reload();          
    })
    .catch((error) => {
      if (error.response.data.message == "EMAIL_EXISTS") {
        toastr.error(
          "Email Alredy Exists",
          "Kindly Login with provided email"
        );
        setTimeout(()=>{
            toastr.removeByType('error')
        },5000)
      } 
    });

  };

  return (
    <>
      {createPortal(
        <>
          <div className={`modal  ${registerModalState ? "is-open" : "d-none"}`}>
            <div className="modal-container">
              <div className="modal-left">
                <h1 className="modal-title">Sign Up</h1>
                <p className="modal-desc"></p>
                <div className="input-block" ref={nameBlock}>
                  <label htmlFor="name" className="input-label">
                    Name
                  </label>
                  <input
                    type="text"
                    name="name"
                    ref={nameInputRef}
                    id="name"
                    placeholder="Enter Name"
                  />
                </div>
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
                <div className="input-block mb-1" ref={confirmPasswordBlock}>
                  <label htmlFor="password" className="input-label">
                    Confirm Password
                  </label>
                  <input
                    type="password"
                    name="password"
                    id="password"
                    ref={confirmPasswordInputRef}
                    placeholder="Password"
                  />
                </div>
                <div className="modal-buttons">
                  <span style={{fontSize:'10px'}} href="" className="col-12">
                    By Signing up , you agree to our <a style={{fontSize:'10px',color:'blue'}} href="">Terms and Conditions</a> and <a style={{fontSize:'10px',color:'blue'}}  href="">Privacy Policy</a>  
                  </span><br />
                </div>
                <div className="modal-buttons">
                  <a href="" className="">

                  </a>
                  <button onClick={Register} className="input-button">
                    Register
                  </button>

                </div>
                <p className="sign-up mt-3">
                  Already have an account? <a href="javascipt:void(0)" onClick={openLoginModal}>Login Now</a>
                </p>
              </div>
              <div className="modal-right">
                <img src="/assets/img/girl.jpg" alt="" />
              </div>
              <button
                onClick={closeModal}
                className="icon-button close-button"
              >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                  <path d="M 25 3 C 12.86158 3 3 12.86158 3 25 C 3 37.13842 12.86158 47 25 47 C 37.13842 47 47 37.13842 47 25 C 47 12.86158 37.13842 3 25 3 z M 25 5 C 36.05754 5 45 13.94246 45 25 C 45 36.05754 36.05754 45 25 45 C 13.94246 45 5 36.05754 5 25 C 5 13.94246 13.94246 5 25 5 z M 16.990234 15.990234 A 1.0001 1.0001 0 0 0 16.292969 17.707031 L 23.585938 25 L 16.292969 32.292969 A 1.0001 1.0001 0 1 0 17.707031 33.707031 L 25 26.414062 L 32.292969 33.707031 A 1.0001 1.0001 0 1 0 33.707031 32.292969 L 26.414062 25 L 33.707031 17.707031 A 1.0001 1.0001 0 0 0 32.980469 15.990234 A 1.0001 1.0001 0 0 0 32.292969 16.292969 L 25 23.585938 L 17.707031 16.292969 A 1.0001 1.0001 0 0 0 16.990234 15.990234 z" />
                </svg>
              </button>
            </div>
          </div>
        </>,
        document.getElementById("modal-register-root")
      )}
    </>
  );
});

export default Register;
