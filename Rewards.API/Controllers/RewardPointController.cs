using System;
using System.Collections.Generic;
using System.Threading.Tasks;
using Application.Shared.Infrastructure.Bootstrapper;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Rewards.API.ApplicationServices.ServiceExtensions;
using Rewards.Application.Commands.AddRewardPoint;
using Rewards.Application.Commands.DeductRewadPoint;
using Rewards.Application.Commands.EarnRewardPoint;
using Rewards.Application.Commands.ShareRewardPoint;
using Rewards.Application.Queries.FetchRewardPoints;
using Rewards.Application.Queries.FetchTotalRewardPoints;
using Rewards.Infrastructure;

namespace Rewards.API.Controllers
{
    [Route("reward-points")]
    [ApiController]
    public class RewardPointController : ControllerBase
    {
        [AllowAnonymous]
        [HttpPost("earn")]
        public async Task<IActionResult> CreateRewardPointAsync([FromBody] EarnRewardPointCommand command, [FromServices] IApplication application)
        {
            var response = await application.ExecuteCommandAsync<RewardsModule, EarnRewardPointCommand>(command);
            return response.ResponseResult();
        }

        [AllowAnonymous]
        [HttpPost("add")]
        public async Task<IActionResult> AddRewardPointAsync([FromBody] AddRewardPointCommand command, [FromServices] IApplication application)
        {
            var response = await application.ExecuteCommandAsync<RewardsModule, AddRewardPointCommand>(command);
            return response.ResponseResult();
        }

        [AllowAnonymous]
        [HttpPost("deduct")]
        public async Task<IActionResult> DeductRewardPointAsync([FromBody] DeductRewardPointCommand command, [FromServices] IApplication application)
        {
            var response = await application.ExecuteCommandAsync<RewardsModule, DeductRewardPointCommand>(command);
            return response.ResponseResult();
        }

        [AllowAnonymous]
        [HttpPost("share")]
        public async Task<IActionResult> ShareRewardPointAsync([FromBody] ShareRewardPointCommand command, [FromServices] IApplication application)
        {
            var response = await application.ExecuteCommandAsync<RewardsModule, ShareRewardPointCommand>(command);
            return response.ResponseResult();
        }

        [AllowAnonymous]
        [HttpGet("{userId}")]
        public async Task<IActionResult> FetchRewardPointsAsync(Guid userId, [FromServices] IApplication application)
        {
            var response = await application.SendQueryAsync<RewardsModule, FetchRewardPointsQuery, IEnumerable<RewardPointDto>>(new FetchRewardPointsQuery(userId));
            return response.ResponseResult();
        }

        [AllowAnonymous]
        [HttpGet("total/{userId}")]
        public async Task<IActionResult> TotalRewardPointsAsync(Guid userId, [FromServices] IApplication application)
        {
            var response = await application.SendQueryAsync<RewardsModule, FetchTotalRewardPointsQuery, double>(new FetchTotalRewardPointsQuery(userId));
            return response.ResponseResult();
        }
    }
}
