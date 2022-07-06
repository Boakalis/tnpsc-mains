import React, { useState, useEffect } from "react";
import axios from "./../helpers/axios";
const Quotes = () => {
let data =[];
  useEffect(() => {
    const options = {
      method: "GET",
      url: "https://motivational-content.p.rapidapi.com/quotes",
      headers: {
        "X-RapidAPI-Key": "1cbb9e2795msh8731758efd6ac7ap1c6338jsnae9360415d65",
        "X-RapidAPI-Host": "motivational-content.p.rapidapi.com",
      },
    };

    axios
      .request(options)
      .then(function(response) {
        data = response.data
        runDbSave();
      })
      .catch(function(error) {
        console.error(error);
      });
  }, []);

  function runDbSave() {
    axios
      .post("/api-to-get-motivation-and-save-in-db", data)
      .then((resp) => {
      })
      .catch((error) => {

      });
  }
  return <div>Quotes</div>;
};

export default Quotes;
