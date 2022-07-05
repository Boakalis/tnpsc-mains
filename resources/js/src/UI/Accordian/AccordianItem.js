import React from "react";
import Accordion from "react-bootstrap/Accordion";
import Card from "../Card/Card";
import AccordianContent from "./AccordianContent";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import  './Accordian.css'

const AccordianItem = (props) => {
  return (
    <div>
      <Accordion.Item  eventKey="0">
        <Accordion.Header> <h6 style={{fontWeight:600}} className=" text-uppercase mb-0 my-1 text-center">Week {props.index + 1}  </h6> </Accordion.Header>
        <AccordianContent>
          <Row md={3} sm={1} lg={3} xl={3} xs={1} xxl={3}>
            {props.data &&
              props.data.map((test) => {
                return (
                  <Col>
                    <Card data={{...test}}></Card>
                  </Col>
                );
              })}
          </Row>
        </AccordianContent>
      </Accordion.Item>
    </div>
  );
};

export default AccordianItem;
