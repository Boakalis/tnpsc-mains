import React, { useEffect, useState, useCallback } from "react";
import axios from "./axios";
import { useSelector, useDispatch } from "react-redux";
import moment from "moment";
import {Navigate} from 'react-router-dom'
import Loader from "./../UI/loader/Loader";
const AuthMiddleWare = (props) => {
    const storedToken = useSelector((state) => state.authentication.user);

    return <>{storedToken == null ? ( window.location.href="/" ) : props.children}</>;
};

export default AuthMiddleWare;
