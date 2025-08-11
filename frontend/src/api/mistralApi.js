import apiClient from "./axiosClient";

export async function testApi(prompt) {
  const res = await apiClient.post("/generate", {
    model: "mistral",
    prompt: prompt,
    max_tokens: 150,
    stream: false,
  });
  return res.data;
}
