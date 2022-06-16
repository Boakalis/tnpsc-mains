import axios from 'axios';
import {useSelector} from 'react-redux';

const token = JSON.parse(localStorage.getItem("rawData")) ? JSON.parse(localStorage.getItem("rawData")).token : '' ;
export default axios.create({
    baseURL:`${process.env.REACT_APP_API_URL}`,
    headers:{
        "Content-type":"application/json",
        'Authorization': 'Bearer '+token
    }
})