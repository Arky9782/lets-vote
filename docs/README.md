# **Let's Vote** Documentation site

This directory contains the code for the **Let's Vote** docs site, [monogramm.github.io/letsvote](https://monogramm.github.io/letsvote).

## Contributing

For information about contributing, see the [Contributing page](https://github.com/Monogramm/letsvote/blob/master/CONTRIBUTING.md).

## Recruitment test

**Let's Vote** is a simple app concept for [dot voting](https://en.wikipedia.org/wiki/Dot-voting) used for recruitment tests.
It comes with a simple generic repository for you to document and test your code.

Use the following links as reference: 
* https://mindiply.com/blog/post/how-to-make-better-group-decision-with-dot-voting

### Task requirements

- All tasks to be completed with an appropriate level of testing.
- Persistence implementation can be any system deemed appropriate by user as long as it is Free and Open.
- Your code should trend towards being SOLID.
- Follow the guidelines listed in the contributing guide.
- Complete the tasks as you fit with the language and framework you feel most comfortable with.
- **Do not fork this repository!** If you have forked it, request GitHub to make your fork a standalone project. The objective is for each candidate to own and display his work, without making the code too easily visible by other candidates.
- Send us a link to your version of the code to [mailto:opensource@monogramm.io](opensource@monogramm.io) but please do not send attached zip files via email!

### Task stories

Please complete each task in order.

_Make sure to commit every completed task to a specific branch `taskX` after completing the task_.

#### Task 1

Copy this git repository on your own GitHub account.

Initialize the project source code with the selected framework or generator.

Configure `.travis.yml` to execute the unit tests provided by your initial project.
Enable [Travis-CI](https://travis-ci.org/) on your fork and ensure all tests run properly.

#### Task 2

As a **user**
I want **to create an _election_**
So that **I can invite people to vote**

**Acceptance criteria**

- Elections **must** have a title
- When saved, Elections **must** have a unique link used for invitation

#### Task 3

As a **user**
I want **to create _choices_ for an election**
So that **I can define the different options for the election**

**Acceptance criteria**

- Choices **must** have a title
- Elections **can** have as many choices as needed

#### Task 4

As a **user**
I want **to access an election**
So that **I can vote for the options of the election**

**Acceptance criteria**

- The Election is accessible publicly by its generated link
- Users have `($number_options / 3) + 1` votes available
- Users can place as many votes on an option as they want
- Users must use all their votes before submitting results
- Vote results must be persisted
- Supported by unit tests and executed by CI.

#### Task 5

As a **developer**
I want **a technical documentation**
So that **I can build, run and test locally the application**

**Acceptance criteria**

- The repository must contain a documentation on how to build and run the application
- The information must be easily found from the README
