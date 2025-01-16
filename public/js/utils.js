export default async function verifyToken(token) {
  const API_URL = "https://flash-cards-fastapi.vercel.app";
  return await new Promise((resolve, reject) => {
    const url = `${API_URL}/verify_token`;
    const headers = {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    };
    fetch(url, { method: "POST", headers })
      .then((response) => {
        if (response.status === 200) {
          return response.json();
        }
        return response.json().then((error) => {
          throw new Error(error.detail);
        });
      })
      .then((data) => {
        resolve(data);
      })
      .catch((error) => {
        reject(error);
      });
  });
}
