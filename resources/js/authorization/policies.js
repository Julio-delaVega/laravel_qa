export default {
    modify(user, model) {
        return user.id === model.user.id;
    },
    acceptBest(user, answer) {
        return user.id === answer.question.user.id;
    },
    deleteQuestion(user, question) {
        return user.id === question.user.id && question.answers_count < 1;
    }
};
