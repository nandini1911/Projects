import React from "react";
import "./App.css";
import Login from "./Login";

function App() {
  const [loggedIn, setLoggedIn] = React.useState(false);
  return loggedIn ? (
    // Storing data in localstorage can be an effective way to cache data. This may come with some security issues.
    <h1>{localStorage.getItem("loginToken")}</h1>
  ) : (
    <Login setLoggedIn={setLoggedIn} />
  );
}

export default App;
