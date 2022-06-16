import React, { useEffect, useState, useCallback } from "react";
import axios from "./axios";
import { useSelector, useDispatch } from "react-redux";
import moment from "moment";
import Loader from './../UI/loader/Loader'
const AuthSecurity = (props) => {
  const storedToken = useSelector((state) => state.authentication.user);
  const [initial, setInitial] = useState(true);
  const dispatch = useDispatch();
  const getUserData = () => {
    axios
      .get("/profile")
      .then((resp) => {
        dispatch({ type: "LOGIN_START" ,payload:resp.data.user});
        setInitial(false);
      })
      .catch((error) => {
        setInitial(false);
        if (error.response.status == 401) {
            localStorage.removeItem('rawData')
        }
      });
  };

  useEffect(() => {
    // if (
    //   moment().isSameOrAfter(
    //     JSON.parse(localStorage.getItem("rawData")).expiry_date
    //   )
    // )
    getUserData();
  }, []);


  return <>
  {initial ? (<Loader></Loader>) : (props.children)}
  
  </>;
};

export default AuthSecurity;
