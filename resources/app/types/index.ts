export interface QuoteI {
  dislike: boolean;
  quote: string;
  like: boolean;
};

export interface RespQuoteI {
  data: QuoteI[];
  total_favorites: number;
  limit: number;
}

export interface FavoriteI {
  id?: number | string;
  dislike: boolean;
  quote: string;
  like: boolean;
};

export interface UserI {
  id?: number | string;
  name: string;
  image: string;
  email: string;
  email_verified_at: string | Date;
  moderating: number;
  banning: boolean;
  created_at: string;
  updated_at: string;
  isAdmin?: boolean;
};

export interface PaginationI<T> {
  data: T[],
  first_page_url: string;
  from: number;
  last_page: number;
  last_page_url: string;
  next_page_url: string
  path: string;
  per_page: number;
  prev_page_url: string | null
  to: number;
  total: number;
  current_page: number,
  links: {
    active: boolean;
    url: string;
    label: string;
  }[];
}
