<template>
  <section>
    <b-loading
      :active.sync="isLoading"
    />
    <b-field label="Title">
      <b-input
        v-model="title"
        maxlength="254"
      />
    </b-field>
    <div
      v-for="(item, index) in choices"
      :key="index"
    >
      <b-field>
        <b-input
          v-model="item.title"
          maxlength="254"
        >
          {{ item.title }}
        </b-input>
      </b-field>
      <b-button @click="deleteRow(index)">
        Delete
      </b-button>
    </div>

    <b-button
      size="is-small"
      @click="addChoiceField"
    >
      Add Choice
    </b-button>

    <b-button
      type="is-primary"
      @click="createElection"
    >
      Create
    </b-button>
  </section>
</template>

<script>
import { mapMutations } from 'vuex';

export default {
  name: "CreateElection",
  data() {
    return {
      choices: []
    }
  },
  computed: {
    title: {
      get() {
        return this.$store.state.election.electionTitle;
      },
      set(value) {
        return this.setTitle(value)
      },
    },
    isLoading: {
      get() {
        return this.$store.state.election.isLoading;
      }
    }
  },
  methods: {
    ...mapMutations({
      'setTitle': 'election/CHANGE_ELECTION_TITLE',
      'setId': 'election/SET_ELECTION_ID',
      'addChoice': 'election/ADD_CHOICE',
    }),
    addChoiceField() {
      this.choices.push({ title: '' })
    },
    deleteRow(index) {
      this.choices.splice(index, 1)
    },
    async createElection() {
      for (let choice of this.choices) {
        this.addChoice( { title: choice.title } )
      }
      const result = await this.$store.dispatch('election/create');

      await this.$router.push({name: 'Vote', params: {hash: result.hash}})
    }
  },
};
</script>