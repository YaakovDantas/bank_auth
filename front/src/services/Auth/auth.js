import http from "../config";

export const login = async ({ credentials }) => {
  try {
    let response = await http.post("auth/login", credentials);
    return response;
  } catch (err) {
    return err;
  }
};

export const create = async ({ data }) => {
  try {
    let response = await http.post("users", data);
    return response;
  } catch (err) {
    return err;
  }
};

export const userAuth = async () => {
  try {
    let response = await http.get("auth/user");
    return response;
  } catch (err) {
    return err;
  }
};

export const logout = async () => {
  try {
    let response = await http.post("auth/logout");
    return response;
  } catch (err) {
    return err;
  }
};
