import Authentication from "@modules/Auth/Api/AuthenticationRepository";

const repositories = {
    authentication: Authentication
};

export const RepositoryFactory = {
    get: name => repositories[name]
};
