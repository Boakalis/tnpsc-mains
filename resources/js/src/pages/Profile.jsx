import { React, useState, useEffect, useRef } from "react";
import Box from "@mui/material/Box";
import Container from "@mui/material/Container";
import CssBaseline from "@mui/material/CssBaseline";
import Card from "./../components/Card";
import Grid from "@mui/material/Grid";
import Typography from "@mui/material/Typography";
import BreadCrumbs from "./../components/BreadCrumbs";
import axios from "./../helpers/axios";
import Skeleton from "@mui/material/Skeleton";
import { useDispatch, useSelector } from "react-redux";
import "./Profile.css";
import { toastr } from "react-redux-toastr";
import CircularProgress from "@mui/material/CircularProgress";

function Profile() {
    const [loading, setLoading] = useState(false);
    const user = useSelector((state) => state.authentication.user);
    const dispatch = useDispatch();
    const [userData, setUserData] = useState(user);
    const name = useRef();
    const email = useRef();
    const phone = useRef();
    const address1 = useRef();
    const address2 = useRef();
    const city = useRef();
    const state = useRef();
    const landmark = useRef();
    const pincode = useRef();
    const nameBlock = useRef();
    const emailBlock = useRef();
    const phoneBlock = useRef();
    const address1Block = useRef();
    const address2Block = useRef();
    const cityBlock = useRef();
    const stateBlock = useRef();
    const landmarkBlock = useRef();
    const pincodeBlock = useRef();
    useEffect(() => {
        console.log(userData);
    });

    const validation = (event) => {
        event.preventDefault();

        if (name.current.value == "") {
            toastr.error("Name is required", "Please Enter Name");
            name.current.focus();
            setTimeout(() => {
                toastr.removeByType("error");
            }, 5000);
            return;
        }

        if (name.current.value.length < 3) {
            toastr.error("Name too short", "Please enter proper name");
            name.current.focus();
            setTimeout(() => {
                toastr.removeByType("error");
            }, 5000);
            return;
        }

        if (email.current.value == "") {
            toastr.error("Email is required", "Please Enter Email Address");
            email.current.focus();
            setTimeout(() => {
                toastr.removeByType("error");
            }, 5000);
            return;
        }
        if (
            !email.current.value.includes("@") ||
            !email.current.value.includes(".") ||
            !email.current.value.includes("com")
        ) {
            toastr.error(
                "Email is invalid",
                "Please Enter proper Email Address"
            );
            email.current.focus();
            setTimeout(() => {
                toastr.removeByType("error");
            }, 5000);
            return;
        }
        if (phone.current.value == "") {
            toastr.error(
                "Phone Number is required",
                "Please Enter Phone Number"
            );
            phone.current.focus();
            setTimeout(() => {
                toastr.removeByType("error");
            }, 5000);
            return;
        }
        if (isNaN(phone.current.value) || phone.current.value.length < 6) {
            toastr.error(
                "Phone Number is invalid",
                "Please Enter proper Phone Number"
            );
            phone.current.focus();
            setTimeout(() => {
                toastr.removeByType("error");
            }, 5000);
            return;
        }

        if (address1.current.value == "") {
            toastr.error(
                "Address field 1 is required",
                "Please Enter proper address"
            );
            address1.current.focus();
            setTimeout(() => {
                toastr.removeByType("error");
            }, 5000);
            return;
        }

        if (address1.current.value.length < 3) {
            toastr.error(
                "Address field 1 too short",
                "Please enter proper address"
            );
            address1.current.focus();
            setTimeout(() => {
                toastr.removeByType("error");
            }, 5000);
            return;
        }

        if (city.current.value == "") {
            toastr.error("City is required", "Please Enter proper city name");
            city.current.focus();
            setTimeout(() => {
                toastr.removeByType("error");
            }, 5000);
            return;
        }

        if (state.current.value == "") {
            toastr.error("State is required", "Please Enter proper state name");
            state.current.focus();
            setTimeout(() => {
                toastr.removeByType("error");
            }, 5000);
            return;
        }

        if (pincode.current.value == "") {
            toastr.error("Pincode is required", "Please Enter proper pincode");
            pincode.current.focus();
            setTimeout(() => {
                toastr.removeByType("error");
            }, 5000);
            return;
        }

        if (isNaN(pincode.current.value) || pincode.current.value.length < 6) {
            toastr.error("Pincode is invalid", "Please Enter proper pincode");
            pincode.current.focus();
            setTimeout(() => {
                toastr.removeByType("error");
            }, 5000);
            return;
        }

        submitData();
    };

    const submitData = () => {
        document.getElementById("submit").classList.add("disabled");
        document.getElementById("text").classList.add("d-none");
        document.getElementById("loaderCircle").classList.remove("d-none");
        axios
            .post("/profile-update", userData)
            .then((resp) => {
                document.getElementById("submit").classList.remove("disabled");
                document.getElementById("text").classList.remove("d-none");
                document.getElementById("loaderCircle").classList.add("d-none");
                dispatch({ type: "LOGIN_START", payload: userData });
                toastr.success("Profile update successfully");
                setTimeout(() => {
                    toastr.removeByType("success");
                }, 5000);
            })
            .catch((error) => {
                console.log(error)
                console.log(error.response.data.message)
                if (error.response.data.error == "MAIL_ERROR") {
                    toastr.error(
                        "Please provide valid data"
                        ,
                        "Email Already Exists"
                    );
                    document.getElementById("submit").classList.remove("disabled");
                    document.getElementById("text").classList.remove("d-none");
                    document.getElementById("loaderCircle").classList.add("d-none");
                    setTimeout(() => {
                        toastr.removeByType("error");
                    }, 5000);
                    return;
                }
                document.getElementById("submit").classList.remove("disabled");
                document.getElementById("text").classList.remove("d-none");
                document.getElementById("loaderCircle").classList.add("d-none");
                toastr.error(
                    "Something went wrong",
                    "Please try again or contact administrator"
                );
                setTimeout(() => {
                    toastr.removeByType("error");
                }, 5000);
            });
    };

    return (
        <>
            <CssBaseline />
            {!loading && <BreadCrumbs title={`PROFILE`} />}

            <Container
                maxWidth="lg"
                className="mt-4"
                style={{ padding: "0px", margin: "0px" }}
            >
                <Box sx={{ bgcolor: "" }}>
                    <div className="row">
                        {/* Basic with Icons */}
                        <div className=" col-12">
                            <div className="card mb-4">
                                <div className="card-body">
                                    {/* <h4 className="text-center my-3">
                                        Personal Details
                                    </h4> */}
                                    <form className="row">
                                        <div className="row mb-3 col-lg-6 col-xl-6 col-12 ">
                                            <label
                                                class="form-label"
                                                for="basic-icon-default-fullname"
                                            >
                                                Full Name
                                                <span style={{ color: "red" }}>
                                                    *
                                                </span>
                                            </label>
                                            <div className="col-sm-10">
                                                <div
                                                    className="input-group input-group-merge"
                                                    ref={nameBlock}
                                                >
                                                    <span
                                                        id="basic-icon-default-fullname2"
                                                        className="input-group-text"
                                                    >
                                                        <i className="bx bx-user" />
                                                    </span>
                                                    <input
                                                        ref={name}
                                                        onInput={() =>
                                                            setUserData(
                                                                (prev) => {
                                                                    return {
                                                                        ...prev,
                                                                        name: name
                                                                            .current
                                                                            .value,
                                                                    };
                                                                }
                                                            )
                                                        }
                                                        type="text"
                                                        className="form-control"
                                                        id="basic-icon-default-fullname"
                                                        placeholder="Enter Name"
                                                        value={userData.name}
                                                        aria-describedby="basic-icon-default-fullname2"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div className="row mb-3 col-6 col-lg-6 col-xl-6 col-12">
                                            <label
                                                class="form-label"
                                                for="basic-icon-default-email"
                                            >
                                                Email
                                                <span style={{ color: "red" }}>
                                                    *
                                                </span>
                                            </label>
                                            <div className="col-sm-10">
                                                <div
                                                    className="input-group input-group-merge"
                                                    ref={emailBlock}
                                                >
                                                    <span className="input-group-text">
                                                        <i className="bx bx-envelope" />
                                                    </span>
                                                    <input
                                                        type="text"
                                                        id="basic-icon-default-email"
                                                        className="form-control"
                                                        placeholder="Email Address"
                                                        ref={email}
                                                        value={userData.email}
                                                        onInput={() =>
                                                            setUserData(
                                                                (prev) => {
                                                                    return {
                                                                        ...prev,
                                                                        email: email
                                                                            .current
                                                                            .value,
                                                                    };
                                                                }
                                                            )
                                                        }
                                                        aria-describedby="basic-icon-default-email"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div className="row mb-3  col-lg-6 col-xl-6 col-12">
                                            <label
                                                class="form-label"
                                                for="basic-default-fullname"
                                            >
                                                Mobile Number
                                                <span style={{ color: "red" }}>
                                                    *
                                                </span>
                                            </label>
                                            <div className="col-sm-10">
                                                <div
                                                    className="input-group input-group-merge"
                                                    ref={phoneBlock}
                                                >
                                                    <span
                                                        id="basic-icon-default-phone2"
                                                        className="input-group-text"
                                                    >
                                                        <i className="bx bx-phone" />
                                                    </span>
                                                    <input
                                                        type="text"
                                                        id="basic-icon-default-phone"
                                                        className="form-control phone-mask"
                                                        placeholder="Enter Mobile Number"
                                                        ref={phone}
                                                        value={userData.phone}
                                                        onInput={() =>
                                                            setUserData(
                                                                (prev) => {
                                                                    return {
                                                                        ...prev,
                                                                        phone: phone
                                                                            .current
                                                                            .value,
                                                                    };
                                                                }
                                                            )
                                                        }
                                                        aria-describedby="basic-icon-default-phone2"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        {/* <h4 className="text-center my-4">
                                            Communication Details
                                        </h4> */}
                                        <div className="row mb-3 col-6 col-lg-6 col-xl-6 col-12 ">
                                            <label
                                                class="form-label"
                                                for="basic-icon-default-address1"
                                            >
                                                Address 1
                                                <span style={{ color: "red" }}>
                                                    *
                                                </span>
                                            </label>
                                            <div className="col-sm-10">
                                                <div
                                                    className="input-group input-group-merge"
                                                    ref={address1Block}
                                                >
                                                    <span
                                                        id="basic-icon-default-address12"
                                                        className="input-group-text"
                                                    >
                                                        <i class="fa-solid fa-map-location-dot"></i>
                                                    </span>
                                                    <input
                                                        type="text"
                                                        className="form-control"
                                                        id="basic-icon-default-address1"
                                                        placeholder="Enter Address Field 1"
                                                        ref={address1}
                                                        value={
                                                            userData.address_1
                                                        }
                                                        onInput={() =>
                                                            setUserData(
                                                                (prev) => {
                                                                    return {
                                                                        ...prev,
                                                                        address_1:
                                                                            address1
                                                                                .current
                                                                                .value,
                                                                    };
                                                                }
                                                            )
                                                        }
                                                        aria-describedby="basic-icon-default-address12"
                                                    />
                                                </div>
                                            </div>
                                        </div>{" "}
                                        <div className="row mb-3 col-6 col-lg-6 col-xl-6 col-12 ">
                                            <label
                                                class="form-label"
                                                for="basic-icon-default-address2"
                                            >
                                                Address 2
                                            </label>
                                            <div className="col-sm-10">
                                                <div
                                                    className="input-group input-group-merge"
                                                    ref={address2Block}
                                                >
                                                    <span
                                                        id="basic-icon-default-address22"
                                                        className="input-group-text"
                                                    >
                                                        <i class="fa-solid fa-map-location-dot"></i>
                                                    </span>
                                                    <input
                                                        type="text"
                                                        className="form-control"
                                                        id="basic-icon-default-address2"
                                                        placeholder="Enter Address field 2 "
                                                        ref={address2}
                                                        value={
                                                            userData.address_2
                                                        }
                                                        onInput={() =>
                                                            setUserData(
                                                                (prev) => {
                                                                    return {
                                                                        ...prev,
                                                                        address_2:
                                                                            address2
                                                                                .current
                                                                                .value,
                                                                    };
                                                                }
                                                            )
                                                        }
                                                        aria-describedby="basic-icon-default-address22"
                                                    />
                                                </div>
                                            </div>
                                        </div>{" "}
                                        <div className="row mb-3 col-6 col-lg-6 col-xl-6 col-12 ">
                                            <label
                                                class="form-label"
                                                for="basic-icon-default-city"
                                            >
                                                City
                                                <span style={{ color: "red" }}>
                                                    *
                                                </span>
                                            </label>
                                            <div className="col-sm-10">
                                                <div
                                                    className="input-group input-group-merge"
                                                    ref={cityBlock}
                                                >
                                                    <span
                                                        id="basic-icon-default-city2"
                                                        className="input-group-text"
                                                    >
                                                        <i class="fa-solid fa-city"></i>
                                                    </span>
                                                    <input
                                                        type="text"
                                                        className="form-control"
                                                        id="basic-icon-default-city"
                                                        placeholder="Enter City Name"
                                                        ref={city}
                                                        value={userData.city}
                                                        onInput={() =>
                                                            setUserData(
                                                                (prev) => {
                                                                    return {
                                                                        ...prev,
                                                                        city: city
                                                                            .current
                                                                            .value,
                                                                    };
                                                                }
                                                            )
                                                        }
                                                        aria-describedby="basic-icon-default-city2"
                                                    />
                                                </div>
                                            </div>
                                        </div>{" "}
                                        <div className="row mb-3 col-6 col-lg-6 col-xl-6 col-12 ">
                                            <label
                                                class="form-label"
                                                for="basic-icon-default-state"
                                            >
                                                State
                                                <span style={{ color: "red" }}>
                                                    *
                                                </span>
                                            </label>
                                            <div className="col-sm-10">
                                                <div
                                                    className="input-group input-group-merge"
                                                    ref={stateBlock}
                                                >
                                                    <span
                                                        id="basic-icon-default-state2"
                                                        className="input-group-text"
                                                    >
                                                        <i class="fa-solid fa-city"></i>
                                                    </span>
                                                    <input
                                                        type="text"
                                                        className="form-control"
                                                        id="basic-icon-default-state"
                                                        placeholder="Enter State Name"
                                                        ref={state}
                                                        value={userData.state}
                                                        onInput={() =>
                                                            setUserData(
                                                                (prev) => {
                                                                    return {
                                                                        ...prev,
                                                                        state: state
                                                                            .current
                                                                            .value,
                                                                    };
                                                                }
                                                            )
                                                        }
                                                        aria-describedby="basic-icon-default-state2"
                                                    />
                                                </div>
                                            </div>
                                        </div>{" "}
                                        <div className="row mb-3 col-6 col-lg-6 col-xl-6 col-12 ">
                                            <label
                                                class="form-label"
                                                for="basic-icon-default-landmark"
                                            >
                                                Landmark
                                            </label>
                                            <div className="col-sm-10">
                                                <div
                                                    className="input-group input-group-merge"
                                                    ref={landmarkBlock}
                                                >
                                                    <span
                                                        id="basic-icon-default-landmark2"
                                                        className="input-group-text"
                                                    >
                                                        <i class="fa-solid fa-landmark"></i>
                                                    </span>
                                                    <input
                                                        type="text"
                                                        className="form-control"
                                                        id="basic-icon-default-landmark"
                                                        placeholder="Enter Landmark name"
                                                        ref={landmark}
                                                        value={
                                                            userData.landmark
                                                        }
                                                        onInput={() =>
                                                            setUserData(
                                                                (prev) => {
                                                                    return {
                                                                        ...prev,
                                                                        landmark:
                                                                            landmark
                                                                                .current
                                                                                .value,
                                                                    };
                                                                }
                                                            )
                                                        }
                                                        aria-describedby="basic-icon-default-landmark2"
                                                    />
                                                </div>
                                            </div>
                                        </div>{" "}
                                        <div className="row mb-3 col-6 col-lg-6 col-xl-6 col-12 ">
                                            <label
                                                class="form-label"
                                                for="basic-icon-default-pincode"
                                            >
                                                Pincode
                                                <span style={{ color: "red" }}>
                                                    *
                                                </span>
                                            </label>
                                            <div className="col-sm-10">
                                                <div
                                                    className="input-group input-group-merge"
                                                    ref={pincodeBlock}
                                                >
                                                    <span
                                                        id="basic-icon-default-pincode"
                                                        className="input-group-text"
                                                    >
                                                        <i class="fa-solid fa-location-dot"></i>
                                                    </span>
                                                    <input
                                                        type="text"
                                                        className="form-control"
                                                        id="basic-icon-default-pincode"
                                                        placeholder="Pincode"
                                                        ref={pincode}
                                                        value={userData.pincode}
                                                        onInput={() =>
                                                            setUserData(
                                                                (prev) => {
                                                                    return {
                                                                        ...prev,
                                                                        pincode:
                                                                            pincode
                                                                                .current
                                                                                .value,
                                                                    };
                                                                }
                                                            )
                                                        }
                                                        aria-describedby="basic-icon-default-pincode2"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        {/* <div className="row my-3 mb-3 col-12 text-center" >
                      <div className="col-sm-12">
                        <div className="row justify-content-center">
                          <div className="col-12">
                            <button type="submit" className="btn btn-xs p-3 btn-primary">
                              Click To Change Password
                            </button>
                          </div>
                        </div>
                      </div>
                    </div> */}
                                        <div className="row my-3 justify-content-end">
                                            <div className="col-12">
                                                <button
                                                    type="submit"
                                                    id="submit"
                                                    className="btn btn-primary"
                                                    onClick={validation}
                                                >
                                                    <CircularProgress
                                                        size="1rem"
                                                        color="error"
                                                        className="d-none"
                                                        id="loaderCircle"
                                                    />{" "}
                                                    <span id="text">
                                                        Update Profile
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </Box>
            </Container>
        </>
    );
}

export default Profile;
