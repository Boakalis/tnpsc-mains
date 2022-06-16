import React from "react";
import ReactDOM from "react-dom/client";
import "./index.css";
import App from "./App";
import reportWebVitals from "./reportWebVitals";
import { BrowserRouter } from "react-router-dom";
import store from "./store";
import { Provider } from "react-redux";
import { AuthContextProvider } from "./store/auth-context";
import ReduxToastr from "react-redux-toastr";
import 'react-redux-toastr/lib/css/react-redux-toastr.min.css'

const root = ReactDOM.createRoot(document.getElementById("root"));

root.render(
  <AuthContextProvider>
    <BrowserRouter>
      <React.StrictMode>
        <Provider store={store}>
          <ReduxToastr
            newestOnTop={false}
            preventDuplicates
            position="top-right"
            getState={(state) => state.toastr} // This is the default
            transitionIn="fadeIn"
            transitionOut="fadeOut"
              // progressBar
              // closeOnToastrClick
          />
          <App />
        </Provider>
      </React.StrictMode>
    </BrowserRouter>
  </AuthContextProvider>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
