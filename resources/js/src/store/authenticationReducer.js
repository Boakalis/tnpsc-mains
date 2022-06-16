const initialState = { user: null };

const authenticationReducer = (state = initialState, action) => {
  if (action.type === "LOGIN_START") {
    return {
      user: action.payload,
    };
  }
  return state;
};

export default authenticationReducer;
