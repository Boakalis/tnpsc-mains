import React from "react";
import Accordion from "react-bootstrap/Accordion";
import AccordianItem from "./AccordianItem";

const Accordian = (props) => {
  return (
    <Accordion  className={`my-3`} defaultActiveKey={["0"]} alwaysOpen>
     <AccordianItem  index={props.index} data={props.data} ></AccordianItem>
    </Accordion>
  );
};

export default Accordian;
