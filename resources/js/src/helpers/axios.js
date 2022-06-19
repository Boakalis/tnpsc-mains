import axios from 'axios';
import {useSelector} from 'react-redux';

const token = JSON.parse(localStorage.getItem("rawData")) ? JSON.parse(localStorage.getItem("rawData")).token : '' ;
export default axios.create({
    baseURL:`http://tnpscmains.com/api/`,
    headers:{
        "Content-type":"application/json",
        'Authorization': 'Bearer '+token
    }
})
