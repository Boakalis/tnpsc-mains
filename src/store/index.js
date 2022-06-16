import { createStore, combineReducers } from "redux";
import { reducer as toastrReducer } from "react-redux-toastr";
import authenticationReducer from "./authenticationReducer";
const initialState = { 
  isOpen: false,
  isRegisterOpen:false,
  isForgetOpen:false,
  isChangePasswordOpen:false,
  paymentLoader:false,
  startPayment:false,
};

const modalReducer = (state = initialState, action) => {
  if (action.type === "OPEN_LOGIN_MODAL") {
    return {
      ...state,
      isOpen: true,
    };
  }
  if (action.type === "CLOSE_LOGIN_MODAL") {
    return {
      ...state,
      isOpen: false,
    };
  }
  if (action.type === "OPEN_REGISTER_MODAL") {
     return {
      ...state,
      isRegisterOpen: true,
    };
  }
  if (action.type === "CLOSE_REGISTER_MODAL") {
    return {
      ...state,
      isRegisterOpen: false,
    };
  }
  if (action.type === "OPEN_FORGET_PASSWORD_MODAL") {
     return {
      ...state,
      isForgetOpen: true,
    };
  }
  if (action.type === "CLOSE_FORGET_PASSWORD_MODAL") {
    return {
      ...state,
      isForgetOpen: false,
    };
  }
  if (action.type === "OPEN_CHANGE_PASSWORD_MODAL") {
     return {
      ...state,
      isChangePasswordOpen: true,
    };
  }
  if (action.type === "CLOSE_CHANGE_PASSWORD_MODAL") {
    return {
      ...state,
      isChangePasswordOpen: false,
    };
  }
  if (action.type === "OPEN_PAYMENT_LOADER") {
     return {
      ...state,
      paymentLoader: true,
    };
  }
  if (action.type === "CLOSE_PAYMENT_LOADER") {
    return {
      ...state,
      paymentLoader: false,
    };
  }
  return state;
};

const reducers = {
  modalReducer: modalReducer,
  toastr: toastrReducer,
  authentication: authenticationReducer,
};

const reducer = combineReducers(reducers);
const store = createStore(reducer);
export default store;
