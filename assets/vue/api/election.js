import axios from "axios";

export default {
  create(election) {
    return axios.post("/api/election",
      election
    );
  },
  getElection(hash) {
    return axios.get(`/api/election/${hash}`);
  },
  saveVotes(electionId, choices) {
    return axios.put(`/api/election/${electionId}`,
      choices
    )
  },
};