#pragma once

#ifdef CPPSQLAPI_EXPORTS
#define CPPSQLAPI_API __declspec(dllexport)
#else
#define CPPSQLAPI_API __declspec(dllimport)
#endif

#include <curl/curl.h>
#include <nlohmann/json.hpp>
#include <string>
#include <vector>
#include <algorithm>

class CPPSQLAPI_API cpp_sql_api
{
	static CURL* curl_handle;
	std::string script_url;

public:

	cpp_sql_api(std::string url);

	cpp_sql_api();

	static void init();

	static void cleanup();

	void set_script_url(std::string url);

	std::string sql_query(std::string query_, std::string db_ = "vntu_iq", std::string fetch_cmd_ = "all");

	~cpp_sql_api();

private:

	static void curl_api(std::string &url, std::string &result_json);

	static void curl_api_with_header(std::string &url, std::string &result_json, std::vector <std::string> &extra_http_header, std::string &post_data, std::string &action);

	static size_t curl_cb(void *content, size_t size, size_t nmemb, std::string *buffer);
};
