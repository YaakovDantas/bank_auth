import http from "../config";

export const runTransaction = async (data, user_id) => {
  try {
    let response = await http.post(`/accounts/${user_id}/transaction`, data, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });
    return response;
  } catch (error) {
    return error.response.data;
  }
};

export const getBalance = async (user_id) => {
  try {
    let response = await http.get(`/accounts/balance/${user_id}`);
    return response;
  } catch (error) {
    return error;
  }
};

export const getHistoric = async (user_id) => {
  try {
    let response = await http.get(`/accounts/historic/${user_id}`);
    return response;
  } catch (error) {
    console.log(error);
    return error;
  }
};
