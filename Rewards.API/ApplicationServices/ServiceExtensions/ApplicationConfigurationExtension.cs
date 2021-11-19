using Application.Shared;
using Application.Shared.Contracts;
using Application.Shared.DataBases;
using Application.Shared.Infrastructure.Bootstrapper;
using Application.Shared.Infrastructure.Emails;
using Application.Shared.Infrastructure.IntegrationEventCore;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.Logging;

namespace Rewards.API.ApplicationServices.ServiceExtensions
{
    public static class ApplicationConfiguationExtension
    {
        private static IEmailServiceConfiguration ExtractEmailConfiguration(this IConfiguration configuration)
        {
            return configuration.GetSection("EmailServiceConfiguration")
                                .Get<EmailServiceConfiguration>();
        }
        private static string ExtractSQLConnectionString(this IConfiguration configuration)
        {
            var connString = configuration.GetConnectionString("SQLDB");
            return connString;
        }
        private static DeploymentConfiguration ExtractDeploymentConfiguration(this IConfiguration configuration)
        {
            return configuration.GetSection("DeploymentConfiguration")
                                .Get<DeploymentConfiguration>();
        }
        //private static TokenSecret ExtractTokenSecret(this IConfiguration configuration)
        //{
        //    return configuration.GetSection("TokenSecret")
        //                        .Get<TokenSecret>();
        //}

        public static CoreModuleSettings ExtractCoreApplicationSettings(this IConfiguration configuration, ILoggerFactory loggerFactory)
        {
            return new CoreModuleSettings()
            {
                SQLDatabaseType = DatabaseTypes.MsSql,
                DeploymentSettings = configuration.ExtractDeploymentConfiguration(),
                EmailSettings = configuration.ExtractEmailConfiguration(),
                EventClient = new EventClient(loggerFactory.CreateLogger("Event publisher")),
                //TokenSecret = configuration.ExtractTokenSecret(),
                LoggerFactory = loggerFactory,
                SQLConnectionString = configuration.ExtractSQLConnectionString()
            };
        }
    }
}
