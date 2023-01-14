export default function auth({ next }) {
  if (!localStorage.getItem("user_token")) {
    return next({
      name: "Login",
    });
  }
  return next();
}
