<template>
  <div>
    <b-loading
      :active.sync="isLoading"
    />

    <div v-if="!isLoading">
      <div>Election: {{ electionTitle }}</div>
      <br>
      <div v-if="alreadyVoted === true">
        <div
          v-for="choice in choices"
          :key="choice.id"
        >
          <div class="choice">
            <div>
              {{ choice.title }}
            </div>
            <div>Votes: {{ choice.votes }}</div>
          </div>
        </div>
      </div>
      <div v-if="alreadyVoted === false">
        <div>Votes Available: {{ votesAvailable }}</div>
        <br>
        <div>Options:</div>
        <br>
        <div>
          <div
            v-for="choice in choices"
            :key="choice.id"
          >
            <div class="choice">
              <div>
                {{ choice.title }}
              </div>
              <div>Votes: {{ choice.votes }}</div>
              <b-button
                v-if="votesAvailable > 0"
                @click="onClick(choice.id)"
              >
                Vote
              </b-button>
            </div>
          </div>
          <b-button
            v-if="votesAvailable == 0"
            @click="save"
          >
            Save
          </b-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters, mapMutations} from 'vuex';

export default {
  name: "Vote",
  computed: {
    electionTitle: {
      get() {
        return this.$store.state.election.title;
      }
    },
    choices: {
      get() {
        return this.$store.state.election.choices;
      }
    },
    votesAvailable: {
      get() {
        return this.$store.state.election.votesAvailable;
      }
    },
    isLoading: {
      get() {
        return this.$store.state.election.isLoading;
      }
    },
    alreadyVoted: {
      get() {
        return this.$store.state.election.alreadyVoted;
      }
    }
  },
  created() {
    const data = {
      hash: this.$route.params.hash,
      alreadyVoted: this.$cookies.get(this.$route.params.hash)
    };
    this.$store.dispatch('election/getElection', data);
  },
  methods: {
    ...mapActions([
      'election/saveVotes'
    ]),
    ...mapGetters([
      'election/electionTitle',
      'election/electionId',
      'election/getChoices',
      'election/votesAvailable',
      'election/isLoading'
    ]),
    ...mapMutations({
      voteForChoice: 'election/VOTE_FOR_CHOICE'
    }),
    onClick(choiceId) {
      this.voteForChoice(choiceId);
    },
    async save() {
      await this.$store.dispatch('election/saveVotes');
    }
  },
};
</script>

<style>
  .choice {
    display: flex;
    flex: auto;
    justify-content: space-between;
  }
</style>