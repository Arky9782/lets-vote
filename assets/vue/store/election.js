import ElectionAPI from "../api/election";

const CREATING_ELECTION = "CREATING_ELECTION",
  CREATING_ELECTION_SUCCESS = "CREATING_ELECTION_SUCCESS",
  CREATING_ELECTION_ERROR = "CREATING_ELECTION_ERROR",
  FETCHING_ELECTIONS = "FETCHING_ELECTIONS",
  FETCHING_ELECTION_TO_VOTE = "FETCHING_ELECTION_TO_VOTE",
  FETCHING_ELECTIONS_ERROR = "FETCHING_ELECTIONS_ERROR",
  ADD_CHOICE = "ADD_CHOICE",
  CHANGE_ELECTION_TITLE = "CHANGE_ELECTION_TITLE",
  VOTE_FOR_CHOICE = "VOTE_FOR_CHOICE",
  FETCHING_ELECTION_TO_SHOW = "FETCHING_ELECTION_TO_SHOW";

export default {
  namespaced: true,
  state: {
    isLoading: false,
    error: null,
    id: 0,
    hash: '',
    title: '',
    choices: [],
    votesAvailable: 0,
    alreadyVoted: false,
  },
  getters: {
    isLoading(state) {
      return state.isLoading;
    },
    hasError(state) {
      return state.error !== null;
    },
    error(state) {
      return state.error;
    },
    title(state) {
      return state.title;
    },
    electionId(state) {
      return state.id;
    },
    getChoices(state) {
      return state.choices;
    },
    votesAvailable(state) {
      return state.votesAvailable;
    }
  },
  mutations: {
    [CREATING_ELECTION](state) {
      state.isLoading = true;
      state.error = null;
    },
    [CREATING_ELECTION_SUCCESS](state) {
      state.isLoading = false;
      state.error = null;
    },
    [CREATING_ELECTION_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
    },
    [FETCHING_ELECTIONS](state) {
      state.isLoading = true;
      state.error = null;
      state.choices = [];
    },
    [FETCHING_ELECTION_TO_VOTE](state, election) {
      state.votesAvailable = Math.round((election.choices.length / 3) + 1);
      state.isLoading = false;
      state.error = null;
      state.id = election.id;
      state.hash = election.hash;
      state.title = election.title;
      for (let choice of election.choices) {
        state.choices.push({
          id: choice.id,
          title: choice.title,
          votes: 0
        })
      }
    },
    [FETCHING_ELECTION_TO_SHOW](state, election) {
      state.isLoading = false;
      state.error = null;
      state.id = election.id;
      state.title = election.title;
      state.choices = election.choices;
      state.alreadyVoted = true;
    },
    [FETCHING_ELECTIONS_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
    },
    [CHANGE_ELECTION_TITLE](state, title) {
      state.title = title;
    },
    [ADD_CHOICE](state, choice) {
      state.choices.push(choice)
    },
    [VOTE_FOR_CHOICE](state, id) {

      for (let choice of state.choices) {
        if (choice.id === id) {
          choice.votes++;
          state.votesAvailable--;
        }
      }
    }
  },
  actions: {
    async create({ commit, state }) {
      commit(CREATING_ELECTION);
      try {
        const data = {
          title: state.title,
          choices: state.choices,
        };

        let response = await ElectionAPI.create(data);
        commit(CREATING_ELECTION_SUCCESS);
        return response.data;
      } catch (error) {
        commit(CREATING_ELECTION_ERROR, error);
        return null;
      }
    },
    async getElection({ commit }, data) {
      commit(FETCHING_ELECTIONS);
      try {
        let response = await ElectionAPI.getElection(data.hash);
        if(data.alreadyVoted === null){
          commit(FETCHING_ELECTION_TO_VOTE, response.data);
        }
        else {
          commit(FETCHING_ELECTION_TO_SHOW, response.data);
        }
        return response.data;
      } catch (error) {
        commit(FETCHING_ELECTIONS_ERROR, error);
        return null;
      }
    },
    async saveVotes({ state, commit }) {
      try {
        state.isLoading = true;
        await ElectionAPI.saveVotes(state.id, state.choices);
        document.cookie = `${state.hash}=1`;
        let response = await ElectionAPI.getElection(state.hash);
        commit(FETCHING_ELECTION_TO_SHOW, response.data);
        return response;
      } catch (error) {
        return null
      }
    }
  }
};