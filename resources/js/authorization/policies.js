export default {
    modify(user, model) {
        return user.id === model.user_id;
    },
    acceptBest(user, answer) {
        return user.id === answer.question.user_id;
    }
};
