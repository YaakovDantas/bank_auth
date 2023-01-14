import http from "../config";

export const getPendings = async () => {
  try {
    let response = await http.get("admin/transactions");
    return response;
  } catch (err) {
    return err;
  }
};

export const updateTransaction = async (data) => {
  try {
    let response = await http.post("admin/transactions", data);
    return response;
  } catch (err) {
    return err;
  }
};
