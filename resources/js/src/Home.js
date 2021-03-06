import { React, useState, useEffect } from "react";
import Box from "@mui/material/Box";
import Container from "@mui/material/Container";
import CssBaseline from "@mui/material/CssBaseline";
import Card from "./components/Card";
import Grid from "@mui/material/Grid";
import Typography from "@mui/material/Typography";
import BreadCrumbs from "./components/BreadCrumbs";
import axios from "./helpers/axios";
import Skeleton from "@mui/material/Skeleton";
import "./Exams/Exam.css";
import TextLoader from "./UI/loader/TextLoader";
import Nr from "./UI/loader/NoResult";
function Home() {
  const [exam, setExam] = useState([]);
  const [loading, setLoading] = useState(true);

  const getExam = () => {
    axios.get("get-exams").then((resp) => {
      setExam(resp.data.data);
      setLoading(false);
    });
  };

  useEffect(() => {
    getExam();
  }, []);

  

  return (
    <>
      <CssBaseline />
      {!loading && <BreadCrumbs title={`EXAMS`} />}

      {loading ? <TextLoader /> : exam.length > 0 ? 
       <Container maxWidth="lg" style={{ padding: "0px", margin: "0px" }}>
       <Box sx={{ bgcolor: "" }}>
           <Grid container spacing={1}>
               {(loading ? Array.from(new Array(6)) : exam).map(
                   (examData, index) => (
                       <Grid className="mt-4" item xs={12} md={4}>
                           {loading ? (
                               <>
                                   <Skeleton
                                       key={index}
                                       variant="rectangular"
                                       height={118}
                                   />{" "}
                                   <Skeleton
                                       key={index}
                                       variant="text"
                                       width={"80%"}
                                   />
                                   <Skeleton
                                       key={index}
                                       variant="text"
                                       width={"60%"}
                                   />
                               </>
                           ) : exam.length > 0 ? (
                               <Card
                                   key={examData.id}
                                   loading={loading}
                                   data={examData}
                               />
                           ) : (
                               <Nr />
                           )}
                       </Grid>
                   )
               )}
           </Grid>
       </Box>
   </Container>
      
      : <Nr />}
    </>
  );
}

export default Home;
