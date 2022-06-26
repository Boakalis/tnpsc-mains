import React, { useRef, useState, useEffect, useImperativeHandle } from "react";
import { createPortal } from "react-dom";
import { useSelector, useDispatch } from "react-redux";
import axios from "../helpers/axios";
import "./Login.css";
import { Row, Container, Col } from "react-bootstrap";
// import "https://use.fontawesome.com/releases/v5.0.10/js/all.js";
import { toastr } from "react-redux-toastr";

const ForgetPassword = React.forwardRef((props, ref) => {
    const emailInputRef = useRef();
    const emailBlock = useRef();
    const otpInputRef = useRef();
    const otpBlock = useRef();
    const passwordBlock = useRef();
    const confirmPasswordBlock = useRef();
    const password = useRef();
    const confirmPassword = useRef();
    const [otp, setOTP] = useState(false);
    const [otpInput, setOTPInput] = useState(false);
    const [email, setEmail] = useState();
    const [passwordInput, setPassword] = useState();
    const modalState = useSelector((state) => state.modalReducer.isForgetOpen);
    const dispatch = useDispatch();
    useEffect(() => {
        emailInputRef.current.focus();
    });

    const closeModal = () => {
        dispatch({ type: "CLOSE_FORGET_PASSWORD_MODAL" });
    };

    const closeOTPModal = () => {
        setOTP(false);
    };

    useEffect(()=>{
        console.log(otpInput)
        console.log(email)
        console.log(passwordInput)
    })
    const PasswordChange = () => {
        if (otpInputRef.current.value == "") {
            otpInputRef.current.focus();
            otpBlock.current.classList.add("error");
            return;
        } else {
            otpBlock.current.classList.remove("error");
        }

        if (!(otpInputRef.current.value.length >= 6)) {
            otpInputRef.current.focus();
            otpBlock.current.classList.add("error");
            toastr.error("Oops!!!", "Invalid OTP");
            setTimeout(() => {
                toastr.removeByType("error");
            }, 5000);
            return;
        } else {
            otpBlock.current.classList.remove("error");
        }
        if (password.current.value == "") {
            password.current.focus();
            passwordBlock.current.classList.add("error");
            return;
        } else {
            passwordBlock.current.classList.remove("error");
        }

        if (!(password.current.value.length >= 6)) {
            password.current.focus();
            passwordBlock.current.classList.add("error");
            toastr.error("Oops!!!", "Password must be atleast 6 characters");
            setTimeout(() => {
                toastr.removeByType("error");
            }, 5000);
            return;
        } else {
            passwordBlock.current.classList.remove("error");
        }

        if (confirmPassword.current.value == "") {
            confirmPasswordBlock.current.classList.add("error");
            confirmPassword.current.focus();
            return;
        } else {
            confirmPasswordBlock.current.classList.remove("error");
        }

        if (!(confirmPassword.current.value === password.current.value)) {
            confirmPassword.current.focus();
            confirmPasswordBlock.current.classList.add("error");
            toastr.error(
                "Oops!!!",
                "Password and Confirm Password must be same"
            );
            setTimeout(() => {
                toastr.removeByType("error");
            }, 5000);
            return;
        } else {
            confirmPasswordBlock.current.classList.remove("error");
        }


        axios.post('/check-otp',{
            email:email,
            password:passwordInput,
            otp:otpInput,
        })
        .then((resp)=>{
            toastr.success(
                "Password Changed",
                "Please login with the new credentials"
            );
            setOTP(false);
            setTimeout(() => {
                toastr.removeByType("success");
            }, 5000);
            return;

        })
        .catch((error)=>{

            if (error.response.data.message == "MAIL_ERROR") {
                toastr.error(
                    "Invalid Data!!!",
                    "Please check the given data"
                );
                setTimeout(() => {
                    toastr.removeByType("error");
                }, 5000);
                return;
            }
            if (error.response.data.message == "OTP_ERROR") {
                toastr.error(
                    "Invalid OTP!!!",
                    "Please check the otp"
                );
                setTimeout(() => {
                    toastr.removeByType("error");
                }, 5000);
                return;
            }
            if (error.response.data.message == "SERVER_ERROR") {
                toastr.error(
                    "Something went wrong",
                    "Please try agin later or contact support"
                );
                setTimeout(() => {
                    toastr.removeByType("error");
                }, 5000);
                return;
            }

        })

    };

    const ForgetPassword = () => {
        let email = emailInputRef.current;
        if (email.value != "" && email.value.includes("@")) {
            emailBlock.current.classList.remove("error");
            axios
                .post("/check-mail", {
                    email: email.value,
                })
                .then((resp) => {
                    dispatch({ type: "CLOSE_FORGET_PASSWORD_MODAL" });
                    toastr.success(
                        "Password Recovery Mail sent successfully",
                        "Please check in your mail and enter OTP to reset password"
                    );
                    setOTP(true);
                    setEmail(email.value);
                    setTimeout(() => {
                        toastr.removeByType("success")
                    }, 3000);
                })
                .catch((error) => {
                    if (error.response.data.message == "GOOGLE_LOGIN") {
                        toastr.error(
                            "Invalid Operation",
                            "We notified that the following mail address was registered using Google Login.So kindly login with previously logged in methods"
                        );
                        setTimeout(() => {
                            toastr.removeByType("error");
                        }, 5000);
                        return;
                    }
                    if (error.response.data.message == "NO_USER") {
                        toastr.error(
                            "User Not Found",
                            "Please provide valid email address to send password-reset link"
                        );
                    } else if (
                        error.response.data.message == "INVALID_CREDENTIALS"
                    ) {
                        toastr.error(
                            "Invalid Credentials",
                            "Please check credentials !!!"
                        );
                    } else {
                        toastr.error(
                            "Something went wrong !",
                            "Please try again later or contact support !!!"
                        );
                    }
                    setTimeout(() => {
                        toastr.removeByType("error")
                    }, 3000);
                });
        } else {
            email.focus();
            emailBlock.current.classList.add("error");
        }
    };

    return (
        <>
            {createPortal(
                <>
                    <div
                        className={`modal  ${
                            modalState ? "is-open" : "d-none"
                        }`}
                    >
                        <div className="modal-container">
                            <div className="modal-left col-12 p-4">
                                <h1 className="modal-title">Forget Password</h1>
                                <p className="modal-desc"></p>
                                <div className="input-block" ref={emailBlock}>
                                    <label
                                        htmlFor="email"
                                        className="input-label"
                                    >
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
                                <div className="modal-buttons">
                                    <a href="" className=""></a>
                                    <button
                                        onClick={ForgetPassword}
                                        className="input-button"
                                    >
                                        Send Password Recovery Mail
                                    </button>
                                </div>
                            </div>
                            {/* <div className="modal-right">
                <img src="/assets/img/boy.jpg" alt="" />
              </div> */}
                            <button
                                onClick={closeModal}
                                className="icon-button close-button"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 50 50"
                                >
                                    <path d="M 25 3 C 12.86158 3 3 12.86158 3 25 C 3 37.13842 12.86158 47 25 47 C 37.13842 47 47 37.13842 47 25 C 47 12.86158 37.13842 3 25 3 z M 25 5 C 36.05754 5 45 13.94246 45 25 C 45 36.05754 36.05754 45 25 45 C 13.94246 45 5 36.05754 5 25 C 5 13.94246 13.94246 5 25 5 z M 16.990234 15.990234 A 1.0001 1.0001 0 0 0 16.292969 17.707031 L 23.585938 25 L 16.292969 32.292969 A 1.0001 1.0001 0 1 0 17.707031 33.707031 L 25 26.414062 L 32.292969 33.707031 A 1.0001 1.0001 0 1 0 33.707031 32.292969 L 26.414062 25 L 33.707031 17.707031 A 1.0001 1.0001 0 0 0 32.980469 15.990234 A 1.0001 1.0001 0 0 0 32.292969 16.292969 L 25 23.585938 L 17.707031 16.292969 A 1.0001 1.0001 0 0 0 16.990234 15.990234 z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div className={`modal  ${otp ? "is-open" : "d-none"}`}>
                        <div className="modal-container">
                            <div className="modal-left col-12 p-4">
                                <h1 className="modal-title">Password Reset</h1>
                                <p className="modal-desc"></p>
                                <div className="input-block" ref={otpBlock}>
                                    <label
                                        htmlFor="otp"
                                        className="input-label"
                                    >
                                        OTP
                                    </label>
                                    <input
                                        type="text"
                                        name="otp"
                                        ref={otpInputRef}
                                        onInput={(event)=>{
                                            setOTPInput(event.target.value)
                                        }}
                                        id="otp"
                                        placeholder="otp"
                                    />
                                </div>

                                <div
                                    className="input-block"
                                    ref={passwordBlock}
                                >
                                    <label
                                        htmlFor="password"
                                        className="input-label"
                                    >
                                        Password
                                    </label>
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        ref={password}
                                        onInput={(event)=>{
                                            setPassword(event.target.value)
                                        }}
                                        placeholder="Password"
                                    />
                                </div>
                                <div
                                    className="input-block mb-1"
                                    ref={confirmPasswordBlock}
                                >
                                    <label
                                        htmlFor="password"
                                        className="input-label"
                                    >
                                        Confirm Password
                                    </label>
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        ref={confirmPassword}
                                        placeholder="Password"
                                    />
                                </div>
                                <div className="modal-buttons">
                                    <a href="" className=""></a>
                                    <button
                                        onClick={PasswordChange}
                                        className="input-button"
                                    >
                                        Reset Password
                                    </button>
                                </div>
                            </div>
                            {/* <div className="modal-right">
                <img src="/assets/img/boy.jpg" alt="" />
              </div> */}
                            <button
                                onClick={closeOTPModal}
                                className="icon-button close-button"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 50 50"
                                >
                                    <path d="M 25 3 C 12.86158 3 3 12.86158 3 25 C 3 37.13842 12.86158 47 25 47 C 37.13842 47 47 37.13842 47 25 C 47 12.86158 37.13842 3 25 3 z M 25 5 C 36.05754 5 45 13.94246 45 25 C 45 36.05754 36.05754 45 25 45 C 13.94246 45 5 36.05754 5 25 C 5 13.94246 13.94246 5 25 5 z M 16.990234 15.990234 A 1.0001 1.0001 0 0 0 16.292969 17.707031 L 23.585938 25 L 16.292969 32.292969 A 1.0001 1.0001 0 1 0 17.707031 33.707031 L 25 26.414062 L 32.292969 33.707031 A 1.0001 1.0001 0 1 0 33.707031 32.292969 L 26.414062 25 L 33.707031 17.707031 A 1.0001 1.0001 0 0 0 32.980469 15.990234 A 1.0001 1.0001 0 0 0 32.292969 16.292969 L 25 23.585938 L 17.707031 16.292969 A 1.0001 1.0001 0 0 0 16.990234 15.990234 z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </>,
                document.getElementById("modal-forget-password-root")
            )}
        </>
    );
});

export default ForgetPassword;
