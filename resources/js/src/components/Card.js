import { React } from "react";
import Box from "@mui/material/Box";
import Card from "@mui/material/Card";
import CardActions from "@mui/material/CardActions";
import CardContent from "@mui/material/CardContent";
import Button from "@mui/material/Button";
import Typography from "@mui/material/Typography";
import PropTypes from "prop-types";
import { CardActionArea } from "@mui/material";
import { NavLink } from "react-router-dom";

const bull = (
  <Box
    component="span"
    sx={{ display: "inline-block", mx: "2px", transform: "scale(0.8)" }}
  ></Box>
);

CardComponent.propTypes = {
  loading: PropTypes.bool,
};

export default function CardComponent({ data }) {
  return (
    <Box sx={{ minWidth: 275 }}>
      <CardActionArea component={NavLink} to={ data.course ==1 ? `/exams/${data.slug}/${data.course_purchase}` : `/exams/${data.slug}` }>
        <Card
          variant="outlined"
          style={{
            backgroundColor: "rgb(231, 238, 230)",
            boxShadow: "10px 10px 10px lightgrey",
            borderRadius: "15px",
            width: "300px",
            height: "160px",
          }}
        >
          <CardContent>
            <Typography variant="h5" component="div">
              {data.name}
            </Typography>

            <Typography variant="body2">{data.description}</Typography>
          </CardContent>
        </Card>
      </CardActionArea>
    </Box>
  );
}
