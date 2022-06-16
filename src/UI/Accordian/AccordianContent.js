import React from "react";
import Accordion from "react-bootstrap/Accordion";

const AccordianContent = (props) => {
  return (
    <div>
      <Accordion.Body>
         {props.children}
      </Accordion.Body>
    </div>
  );
};

export default AccordianContent;
