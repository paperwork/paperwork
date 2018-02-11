//@flow

export type JwtCredentials = {
    consumer_id: string,
    created_at: number,
    id: string,
    key: string,
    secret: string
};

export type JwtToken = string;

